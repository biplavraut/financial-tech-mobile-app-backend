import Model from "./Model";
import { MUNICIPALITY_INDEX_URL } from "@routes/admin";
import Api from "../Api";

export default class Municipality extends Model {
    constructor(data) {
        super(data);
        this.indexUrl = MUNICIPALITY_INDEX_URL;
        this.namePlural = "municipalities";
    }

    getAll() {
        return Api.get(this.indexUrl + "/get-all");
    }

    getFilterByDistrict(district) {
        return Api.get(this.indexUrl + "/get-filter/"+district);
    }
}
