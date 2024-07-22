import Model from "./Model";
import { BANK_ACCOUNT_TYPE_INDEX_URL } from "@routes/admin";

export default class BankAccountType extends Model {
    constructor(data) {
        super(data);
        this.indexUrl = BANK_ACCOUNT_TYPE_INDEX_URL;
        this.namePlural = "bankAccountTypes";
        this.nameLowerCase = "bankAccountType";
    }

}