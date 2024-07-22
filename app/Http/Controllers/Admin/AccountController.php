<?php

namespace App\Http\Controllers\Admin;

use App\Models\Account;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AccountRequest;
use App\Http\Resources\Admin\AccountListResource;
use App\Http\Resources\Admin\AccountResource;
use App\Services\AccountService;
use Illuminate\Http\Request;

class AccountController extends CommonController
{

    /**
     * @var AccountService
     */
    private $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->middleware('auth:admin');
        $this->accountService = $accountService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $account = $this->accountService->getForIndex(
            $this->paginationLimit
        );
        return AccountResource::collection($account);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccountRequest $request)
    {
        //
        $data = $request->validated();
        $order = $this->accountService->query()->max('order') + 1;
        $request->merge(['order' => $order]);

        $store = $this->accountService->store($request->all());
        if ($store) {
            return new AccountResource($store);
        } else {
            return failureResponse('Something Went wrong');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($account)
    {
        //
        $data = $this->accountService->findOrFail($account);
        return new AccountResource($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AccountRequest $request, $account)
    {
        //
        $update = $request->validated();
        $data  = $this->accountService->update($account, $update);
        return new AccountResource($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($account)
    {
        //
        $findrecord = $this->accountService->findOrFail($account);
        $deleteRecord = $findrecord->delete();
        if ($deleteRecord) {
            return successResponse('success');
        } else {
            return failureResponse("Unable to perform action.");
        }
    }

    public function search(Request $request)
    {
        $data = $this->accountService->query()->where('title', 'LIKE', $request->searchText . '%')->paginate($this->paginationLimit);

        return AccountResource::collection($data);
    }


    public function getAccountList()
    {
        $account  = $this->accountService->query()->where('parent', null)->get();

        //return $final_result;
        return AccountListResource::collection($account);
    }

    public function orderAccounts(Request $request)
    {
        $newlist = $request->accounts;
        try {
            //code...
            $saveList = $this->saveList($newlist);
            if ($saveList) {
                return successResponse('success');
            } else {
                return failureResponse('DB Error!');
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /*Sorting the content in order and making child*/
    public function saveList($list, $parent_id = 0, $child = 0, &$m_order = 0)
    {
        foreach ($list as $item) {

            $m_order++;
            $this->updateOrder($parent_id, $child, $m_order, $item['id']);

            if (array_key_exists("children", $item)) {
                if (count($item['children']) >= 1) {
                    $this->updateParent($child = 1, $item["id"]);
                } else {
                    $this->updateParent($child = 0, $item["id"]);
                }
                $this->saveList($item["children"], $item["id"], 0, $m_order);
            }
        }
        return true;
    }
    protected function updateOrder($parent_id, $child, $m_order, $id)
    {
        $category_order = Account::findOrFail($id);
        if ($category_order) {
            return Account::where('id', '=', $id)->update([
                'parent_id' => $parent_id,
                'child' => $child,
                'order_item' => $m_order
            ]);
        }
    }
    protected function updateParent($child, $id)
    {
        return Account::where('id', '=', $id)->update(['child' => $child]);
    }
}
