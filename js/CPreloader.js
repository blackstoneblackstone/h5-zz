function CPreloader() {
    var _oLoadingText;
    var _iPerc;

    this._init = function () {
        s_oSpriteLibrary.init(this._onImagesLoaded, this._onAllImagesLoaded, this);
        s_oSpriteLibrary.addSprite("logo", "../img/logo.png");
        s_oSpriteLibrary.loadSprites();
    };
    this.unload = function (call) {

    };
    this._onImagesLoaded = function () {

    };

    this._onAllImagesLoaded = function () {
        this._attachSprites()
        s_oMain.preloaderReady();
    };

    //添加Loading页面的元素
    this._attachSprites = function () {

    };

    //执行
    this.update = function () {

    }

    this.refreshLoader = function (iPerc) {
        _iPerc = iPerc;
        $("#shu").text(_iPerc + "%");
    };


    this._init();


}

