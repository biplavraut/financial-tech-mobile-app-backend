import Model from "./Model";
import { SERVICE_REQUEST_INDEX_URL } from "@routes/admin";
import Api from "../Api";

export default class ServiceRequest extends Model {
    constructor(data) {
        super(data);
        this.indexUrl = SERVICE_REQUEST_INDEX_URL;
        this.namePlural = "serviceRequests";
        this.nameLowerCase = "serviceRequest";
    }
    getAll(type) {
        return Api.get(this.indexUrl + "/get-all/"+type);
    }
}