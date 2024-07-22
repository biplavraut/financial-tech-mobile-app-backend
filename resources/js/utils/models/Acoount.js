import Model from "./Model";
import { ACCOUNT_INDEX_URL } from "@routes/admin";
import Api from "../Api";

export default class Account extends Model {
    constructor(data) {
        super(data);
        this.indexUrl = ACCOUNT_INDEX_URL;
        this.namePlural = "accounts";
        this.nameLowerCase = "account";
    }
    getAll(type) {
        return Api.get(this.indexUrl + "/get-all/"+type);
    }
}