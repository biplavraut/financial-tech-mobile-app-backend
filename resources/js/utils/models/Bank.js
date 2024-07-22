import Model from "./Model";
import { BANK_INDEX_URL } from "@routes/admin";

export default class Bank extends Model {
    constructor(data) {
        super(data);
        this.indexUrl = BANK_INDEX_URL;
        this.namePlural = "banks";
        this.nameLowerCase = "bank";
    }

}