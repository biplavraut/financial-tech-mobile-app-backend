import Model from "./Model";
import { BANK_LOAN_TYPE_INDEX_URL } from "@routes/admin";

export default class BankLoanType extends Model {
    constructor(data) {
        super(data);
        this.indexUrl = BANK_LOAN_TYPE_INDEX_URL;
        this.namePlural = "bankLoanTypes";
        this.nameLowerCase = "bankLoanType";
    }

}