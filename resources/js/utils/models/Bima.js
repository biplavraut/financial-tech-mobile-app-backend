import Model from "./Model";
import { BIMA_INDEX_URL } from "@routes/admin";

export default class Bima extends Model {
    constructor(data) {
        super(data);
        this.indexUrl = BIMA_INDEX_URL;
        this.namePlural = "bimas";
        this.nameLowerCase = "bima";
    }

}