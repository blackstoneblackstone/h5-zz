/**
 * Created by lihb on 3/6/17.
 */


function Page3() {
    var b1, animation, l, r;
    this._init = function () {
        var $scene = $('#p2Scene');
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

        var data = {
            images: [s_oSpriteLibrary.getSprite('p2b')],
            frames: {width: 750, height: 1093, spacing: 0},
            framerate: 2,
            animations: {
                stand: 1,
                run: [0, 3]
            }
        };
        var spriteSheet = new createjs.SpriteSheet(data);
        animation = new createjs.Sprite(spriteSheet, "run");
        animation.x = 0;
        animation.y = CANVAS_HEIGHT - 1150;
        s_oStage.addChild(animation);

        var rdata = {
            images: [s_oSpriteLibrary.getSprite('p2r')],
            frames: {width: 92, height: 99, spacing: 0},
            framerate: 3,
            animations: {
                stop: 1,
                an: 0
            }
        };
        var rspriteSheet = new createjs.SpriteSheet(rdata);
        r = new createjs.Sprite(rspriteSheet, "an");
        r.x = 200;
        r.y = CANVAS_HEIGHT - 250;
        s_oStage.addChild(r);

        var ldata = {
            images: [s_oSpriteLibrary.getSprite('p2l')],
            frames: {width: 92, height: 99, spacing: 0},
            framerate: 3,
            animations: {
                stop: 1,
                an: 0
            }
        };
        var lspriteSheet = new createjs.SpriteSheet(ldata);
        l = new createjs.Sprite(lspriteSheet, "stop");
        l.x = CANVAS_WIDTH - 200 - 92;
        l.y = CANVAS_HEIGHT - 250;
        s_oStage.addChild(l);

        var anState = 0;
        l.on("mousedown", function () {
            if (anState == 0) {
                l.gotoAndPlay("an");
                r.gotoAndPlay("stop");
                animation.framerate = animation.framerate + 1;
                anState = 1;
            }
        });
        r.on("mousedown", function () {
            if (anState == 1) {
                r.gotoAndPlay("an");
                l.gotoAndPlay("stop");
                animation.framerate = animation.framerate + 1;
                anState = 0;
            }
        });
        setInterval(function () {
            if(animation.framerate>2){
                animation.framerate = animation.framerate -2;
            }
        },1000);
        
        

    }

    this._init();
}