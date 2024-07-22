import Model from "./Model";
import { BIMA_ACCOUNT_TYPE_INDEX_URL } from "@routes/admin";

export default class BimaAccountType extends Model {
    constructor(data) {
        super(data);
        this.indexUrl = BIMA_ACCOUNT_TYPE_INDEX_URL;
        this.namePlural = "bimaAccountTypes";
        this.nameLowerCase = "bimaAccountType";
    }

}