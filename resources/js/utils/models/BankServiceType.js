import Model from "./Model";
import { BANK_SERVICE_TYPE_INDEX_URL } from "@routes/admin";

export default class BankServiceType extends Model {
    constructor(data) {
        super(data);
        this.indexUrl = BANK_SERVICE_TYPE_INDEX_URL;
        this.namePlural = "bankAccountTypes";
        this.nameLowerCase = "bankAccountType";
    }

}