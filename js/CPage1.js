/**
 * Created by lihb on 3/6/17.
 */


function Page1() {
    this._init = function () {
        createjs.Sound.play("bg",{loop:-1});
        var $scene = $('#p1Scene');
        $scene.parallax({
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
        $(".p1,.p2").fadeIn();
        touch.on("#open", "tap", function () {
            var page2 = new Page2();
            $(".dr").css("-webkit-animation", "dr 3s forwards");
            $(".dr").css("animation", "dr 3s forwards");
            $(".dl").css("-webkit-animation", "dl 6s forwards");
            $(".dl").css("animation", "dl 3s forwards");
            $(this).hide();
            setTimeout(function () {
                $("#f").fadeIn();
                setTimeout(function () {
                    $("#f").fadeOut();
                }, 2000);
            }, 2000)
            setTimeout(function () {
                $(".p1").fadeOut();
                page2.change();
            }, 2500)
        })

    }

    this._init();
}