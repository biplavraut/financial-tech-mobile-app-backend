<?php
namespace App\Services;

use App\Custom\ModelCrud;

abstract class ModelService
{
    /**
     * @var ModelCrud
     */
    protected $modelCrud;

    public function __construct()
    {
        $this->modelCrud = new ModelCrud();
    }

    /**
     * Returns new static builder instance
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return call_user_func(static::MODEL . '::query');
    }

    /**
     * Returns this month data in this format [1=>5, 2=>4, ...., 28=>3]
     *
     * @return array
     */
    public function thisMonthData()
    {
        $usersThisMonth = $this->query()
        ->selectRaw('count(id) as count, substring(created_at,9,2) as day')
        ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()->addDay()])
        ->groupBy('day')
        ->pluck('count', 'day')
        ->toArray();

        $returnData  = [];
        $daysInMonth = range(1, now()->daysInMonth);
        foreach ($daysInMonth as $value) {
            $key = sprintf('%02d', $value);

            $returnData[$value] = $usersThisMonth[$key] ?? 0;
        }

        return $returnData;
    }

    /**
     * Get fresh instance of model
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getNewModel()
    {
        return $this->query()->newModelInstance();
    }


    /**
     * Get row count
     *
     * @return int
     */
    public function getCount()
    {
        return $this->query()->count();
    }

    /**
     * Store data to database
     *
     * @param array $options
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store($options = [])
    {
        return $this->modelCrud->setModel($this->getNewModel())->save($options);
    }

    /**
     * Update data by model
     *
     * @param int $id
     * @param array $options
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($id, $options = [])
    {
        $model = $this->findOrFail($id);

        return $this->updateByModel($model, $options);
    }

    /**
     * Update data by model
     *
     * @param       $model
     * @param array $options
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function updateByModel($model, $options = [])
    {
        return $this->modelCrud->setModel($model)->save($options);
    }

    
    /**
     * Get a row searching by id otherwise throw ModelNotFoundException exception
     *
     * @param       $id
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function findOrFail($id, $columns = ['*'])
    {
        return $this->query()->findOrFail($id, $columns);
    }

    /**
     * Get a row searching by column name otherwise throw ModelNotFoundException exception
     *
     * @param $column
     * @param $value
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function findOrFailBy($column, $value, $columns = ['*'])
    {
        return $this->query()->where($column, $value)->firstOrFail($columns);
    }


    /**
     * Delete a row from the database
     *
     * @param $model
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function deleteByModel($model)
    {
        $model->delete();

        return $model;
    }

    /**
     * Delete a row from the database
     *
     * @param int $id
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function delete($id)
    {
        $model = $this->findOrFail($id);

        return $this->deleteByModel($model);
    }

    public function deleteMultiple($ids)
    {
        $model = static::MODEL;

        return $model::destroy($ids);
    }
}