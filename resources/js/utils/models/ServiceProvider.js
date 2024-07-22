import Model from "./Model";
import { SERVICE_PROVIDER_INDEX_URL } from "@routes/admin";

export default class ServiceProvider extends Model {
    constructor(data) {
        super(data);
        this.indexUrl = SERVICE_PROVIDER_INDEX_URL;
        this.namePlural = "serviceProviders";
        this.nameLowerCase = "service-provider";
    }

}