var ii = 1, ss = 500, inset;
function loading(target, callback, progressfun) {
    if (target instanceof jQuery)
        target = target[0];
    var loadedlen = 0;
    var url = [];
    var len = $(target.document).find('img').length;
    $(target.document).find("*").each(function () {
        var bgi = $(this).css('backgroundImage');
        if (bgi != 'none') {
            len++;
            url.push(bgi.substr(4, bgi.length - 5));
        }
    });
    $(target.document).find('img').each(function (index) {
        url.push(this.src);
    })
    if (url.length == 0) {
        setTimeout(callback, 0);
        return;
    }


    for (var i = 0; i < url.length; i++) {
        var img = new Image();
        img.onerror = img.onload = function () {
            loadedlen++;
            progressfun(Math.floor(loadedlen / len * 100));
            if (loadedlen >= len) {
                callback();
            }
        }
        img.src = url[i];
        img.style.display = 'none';
    }
}

function p1() {
   

}

function p2() {
    $("#p2Scene").parallax({
        calibrateX: false,
        calibrateY: true,
        invertX: false,
        invertY: true,
        limitX: 0,
        limitY: 50,
        scalarX: 2,
        scalarY: 8,
        frictionX: 0.2,
        frictionY: 0.8
    });
    $("#p2b1").show();
    $("#p2b2").hide();
    $("#p2b3").hide();
    

    touch.on("#control", "tap", function () {
            if (ii == 1) {
                ii = 2;
                $("#p2b1").show();
                $("#p2b2").hide();
                $("#p2b3").hide();
                $("#p2b4").hide();
                return;
            }
            if (ii == 2) {
                ii = 3;
                $("#p2b1").hide();
                $("#p2b2").show();
                $("#p2b3").hide();
                $("#p2b4").hide();
                return;
            }
            if (ii == 3) {
                ii = 4;
                $("#p2b1").hide();
                $("#p2b2").hide();
                $("#p2b3").show();
                $("#p2b4").hide();
                return;
            }
            if (ii == 4) {
                ii = 1;
                $("#p2b1").hide();
                $("#p2b2").hide();
                $("#p2b3").hide();
                $("#p2b4").show();
                return;
            }
        }
    )


}
$(function () {
    p2();
});


