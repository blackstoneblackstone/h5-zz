function CMain(oData) {
    var _bUpdate;
    var _iCurResource = 0;
    var RESOURCE_TO_LOAD = 0;
    var _oData;
    var _oPreloader;

    this.initContainer = function () {
        var s_oCanvas = document.getElementById("gameCanvas");
        s_oStage = new createjs.Stage(s_oCanvas);
        createjs.Touch.enable(s_oStage);


        s_oSpriteLibrary = new CSpriteLibrary();

        _oPreloader = new CPreloader();
        CURRENT_PAGE = _oPreloader;
        createjs.Ticker.addEventListener("tick", this._update);
        createjs.Ticker.setFPS(21);
    };

    this.preloaderReady = function () {
        this._initSounds();
        this._loadImages();
        _bUpdate = true;
    };

    //初始化声音
    this._initSounds = function () {
        if (!createjs.Sound.initializeDefaultPlugins()) {
            return;
        }
        createjs.Sound.alternateExtensions = ["ogg"];
        createjs.Sound.addEventListener("fileload", createjs.proxy(this.soundLoaded, this));
        createjs.Sound.registerSound("../sounds/bg.mp3", "bg");
        createjs.Sound.registerSound("../sounds/run.mp3", "run");
        RESOURCE_TO_LOAD += 2;
    };

    //下载图片
    this._loadImages = function () {
        s_oSpriteLibrary.init(this._onImagesLoaded, this._onAllImagesLoaded, this);
        // s_oSpriteLibrary.addSprite("m1", "../img/music1.png");
        // s_oSpriteLibrary.addSprite("m2", "../img/music2.png");
        s_oSpriteLibrary.addSprite("p1dl", "../img/p1-door-l.png");
        s_oSpriteLibrary.addSprite("p1dr", "../img/p1-door-r.png");
        s_oSpriteLibrary.addSprite("p1f", "../img/p1-f.png");
        s_oSpriteLibrary.addSprite("p1mid", "../img/p1-mid.png");
        s_oSpriteLibrary.addSprite("p1t1", "../img/p1-ta-1.png");
        s_oSpriteLibrary.addSprite("p1t2", "../img/p1-ta-2.png");
        s_oSpriteLibrary.addSprite("p1y1", "../img/p1-yun-1.png");
        s_oSpriteLibrary.addSprite("p1y2", "../img/p1-yun-2.png");
        s_oSpriteLibrary.addSprite("p1y3", "../img/p1-yun-3.png");
        s_oSpriteLibrary.addSprite("p2hd", "../img/p2-hd.png");
        s_oSpriteLibrary.addSprite("p2top", "../img/p2-top.jpg");
        s_oSpriteLibrary.addSprite("p2b", "../img/p2-b.png");
        s_oSpriteLibrary.addSprite("p2r", "../img/p2-r.png");
        s_oSpriteLibrary.addSprite("p2l", "../img/p2-l.png");
        s_oSpriteLibrary.addSprite("p2h1", "../img/p2-h1.png");
        s_oSpriteLibrary.addSprite("p2h2", "../img/p2-h2.png");
        s_oSpriteLibrary.addSprite("p2hd1", "../img/p2-hd1.png");
        s_oSpriteLibrary.addSprite("p2hd2", "../img/p2-hd2.png");
        s_oSpriteLibrary.addSprite("p2end", "../img/p2-end.png");
        s_oSpriteLibrary.addSprite("p2cz", "../img/p2-cz.png");
        s_oSpriteLibrary.addSprite("p2start", "../img/p2-start.png");
        s_oSpriteLibrary.addSprite("p3hg", "../img/p3-hg.jpg");
        s_oSpriteLibrary.addSprite("p3btn", "../img/p3-btn.png");
        s_oSpriteLibrary.addSprite("p4bg", "../img/p4-bg.jpg");
        s_oSpriteLibrary.addSprite("p1f", "../img/p1-f.png");
        s_oSpriteLibrary.addSprite("hb", "../img/hb.png");
        s_oSpriteLibrary.addSprite("hb3", "../img/hb3.png");
        RESOURCE_TO_LOAD += s_oSpriteLibrary.getNumSprites();
        s_oSpriteLibrary.loadSprites();
    };


    //一个图片下载完成
    this._onImagesLoaded = function () {
        _iCurResource++;
        var iPerc = Math.floor(_iCurResource / RESOURCE_TO_LOAD * 100);
        _oPreloader.refreshLoader(iPerc);
        if (_iCurResource === RESOURCE_TO_LOAD) {
            setTimeout(function () {
                s_oMain._gotoPage1();
            }, 100);
        }
    };

    this.soundLoaded = function () {
        _iCurResource++;
        var iPerc = Math.floor(_iCurResource / RESOURCE_TO_LOAD * 100);
        _oPreloader.refreshLoader(iPerc);
        if (_iCurResource === RESOURCE_TO_LOAD) {
            s_oMain._gotoPage1();
        }
    };

    this._gotoPage1 = function () {
        $(".loading").fadeOut();
        $(".p2").fadeIn();
        new Page1();
    }
    this._onAllImagesLoaded = function () {

    };

    this.onAllPreloaderImagesLoaded = function () {
        this._loadImages();
    };


    this.stopUpdate = function () {
        _bUpdate = false;
    };

    this.startUpdate = function () {
        _bUpdate = true;
    };

    this._update = function (event) {
        if (_bUpdate === false) {
            return;
        }
        CURRENT_PAGE.update();
        s_oStage.update(event);
    };

    s_oMain = this;

    this.initContainer();
}
var s_iPrevTime = 0;

var s_oStage;
var s_oMain;
var s_oSpriteLibrary;
var s_oCanvas;
