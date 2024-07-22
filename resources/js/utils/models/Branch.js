import Model from "./Model";
import { BRANCH_INDEX_URL } from "@routes/admin";

export default class Bank extends Model {
    constructor(data) {
        super(data);
        this.indexUrl = BRANCH_INDEX_URL;
        this.namePlural = "branches";
        this.nameLowerCase = "branch";
    }

}