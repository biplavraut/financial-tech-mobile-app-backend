export default class Helpers {
    static focusFirstError(errors) {
        let element = document.querySelector(
            `[name="${errors.items[0].field}"]`
        );
        console.log(element);
        if (element) element.focus();
    }

    static focusId(id) {
        let element = document.getElementById(id);
        if (element) element.focus();
    }

    static nullToEmptyString(data, defaultValue = "") {
        return data ? data : defaultValue;
    }

    static cameraImage() {
        return "/storage/images/camera.png";
    }

    static loadingImage() {
        return "/storage/images/loading.gif";
    }

    static objToUrlParams(obj) {
        return Object.keys(obj)
            .map(
                (key) =>
                    encodeURIComponent(key) + "=" + encodeURIComponent(obj[key])
            )
            .join("&");
    }

    static mySlug(title) {
        var slug = "";
        // Change to lower case
        var titleLower = title.toLowerCase();
        // Letter "e"
        slug = titleLower.replace(/e|é|è|ẽ|ẻ|ẹ|ê|ế|ề|ễ|ể|ệ/gi, 'e');
        // Letter "a"
        slug = slug.replace(/a|á|à|ã|ả|ạ|ă|ắ|ằ|ẵ|ẳ|ặ|â|ấ|ầ|ẫ|ẩ|ậ/gi, 'a');
        // Letter "o"
        slug = slug.replace(/o|ó|ò|õ|ỏ|ọ|ô|ố|ồ|ỗ|ổ|ộ|ơ|ớ|ờ|ỡ|ở|ợ/gi, 'o');
        // Letter "u"
        slug = slug.replace(/u|ú|ù|ũ|ủ|ụ|ư|ứ|ừ|ữ|ử|ự/gi, 'u');
        // Letter "d"
        slug = slug.replace(/đ/gi, 'd');
        // Trim the last whitespace
        slug = slug.replace(/\s*$/g, '');
        // Change whitespace to "-"
        slug = slug.replace(/\s+/g, '-');

        return slug;
    }
}
