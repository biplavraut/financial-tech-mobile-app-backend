import Model from "./Model";
import { SERVICE_INDEX_URL } from "@routes/admin";
import Api from "../Api";

export default class Service extends Model {
    constructor(data) {
        super(data);
        this.indexUrl = SERVICE_INDEX_URL;
        this.namePlural = "services";
        this.nameLowerCase = "service";
    }
    getAll(type) {
        return Api.get(this.indexUrl + "/get-all/" + type);
    }

}