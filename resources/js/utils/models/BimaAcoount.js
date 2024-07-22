import Model from "./Model";
import { BIMA_ACCOUNT_INDEX_URL } from "@routes/admin";
import Api from "../Api";

export default class BimaAccount extends Model {
    constructor(data) {
        super(data);
        this.indexUrl = BIMA_ACCOUNT_INDEX_URL;
        this.namePlural = "bima-accounts";
        this.nameLowerCase = "bima-account";
    }
    getAll(type) {
        return Api.get(this.indexUrl + "/get-all/"+type);
    }
}