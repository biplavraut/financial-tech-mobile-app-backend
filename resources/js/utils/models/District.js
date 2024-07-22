import Model from "./Model";
import { DISTRICT_INDEX_URL } from "@routes/admin";
import Api from "../Api";

export default class District extends Model {
    constructor(data) {
        super(data);
        this.indexUrl = DISTRICT_INDEX_URL;
        this.namePlural = "districts";
    }

    getAll() {
        return Api.get(this.indexUrl + "/get-all");
    }
}
