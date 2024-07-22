import Model from "./Model";
import { KYC_INDEX_URL } from "@routes/admin";

export default class Kyc extends Model {
    constructor(data) {
        super(data);
        this.indexUrl = KYC_INDEX_URL;
        this.namePlural = "kycs";
        this.nameLowerCase = "kyc";
    }

}