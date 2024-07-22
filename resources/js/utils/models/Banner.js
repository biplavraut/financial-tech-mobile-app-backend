import Model from "./Model";
import { BANNER_INDEX_URL } from "@routes/admin";

export default class Banner extends Model {
    constructor(data) {
        super(data);
        this.indexUrl = BANNER_INDEX_URL;
        this.namePlural = "banners";
        this.nameLowerCase = "banner";
    }

}