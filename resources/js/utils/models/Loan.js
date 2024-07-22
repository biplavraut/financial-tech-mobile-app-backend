import Model from "./Model";
import { LOAN_INDEX_URL } from "@routes/admin";
import Api from "../Api";

export default class Loan extends Model {
    constructor(data) {
        super(data);
        this.indexUrl = LOAN_INDEX_URL;
        this.namePlural = "loans";
        this.nameLowerCase = "loan";
    }
    getAll(type) {
        return Api.get(this.indexUrl + "/get-all/"+type);
    }
}