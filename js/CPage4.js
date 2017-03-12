/**
 * Created by lihb on 3/6/17.
 */


function Page4() {
    var p4bg;
    this._init = function () {

        p4bg=createBitmap(s_oSpriteLibrary.getSprite('p4bg'));
        s_oStage.addChild(p4bg);

        p4bg.on("mousedown", function () {
            callpay();
        });
        
    }

    this._init();
}