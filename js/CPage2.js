/**
 * Created by lihb on 3/6/17.
 */


function Page2() {
    var animation, l, r, h1, h2, p2end, snum, snumt, hb3, h3, h4, h5, hd1, hd2, page2, container, hbcontainer, hbdsa, hbname, hbmoney;
    var hbn = 0;
    var hbanstate = false;
    var hongbaotext = [{
        name: "多乐之日",
        money: 20
    }, {
        name: "水果捞",
        money: 5
    }, {
        name: "热热凉凉",
        money: 5
    }, {
        name: "老家小食",
        money: 5
    }, {
        name: "撩咋嘞",
        money: 5
    }, {
        name: "稻香村",
        money: 5
    }, {
        name: "弹丸滋地",
        money: 5
    }, {
        name: "熊手包",
        money: 5
    }, {
        name: "米果奇缘",
        money: 5
    }, {
        name: "初代",
        money: 10
    }, {
        name: "maka maka",
        money: 5
    }, {
        name: "阿甘家牛排杯",
        money: 5
    }, {
        name: "御吉缘",
        money: 5
    }, {
        name: "唐饼家",
        money: 5
    }, {
        name: "果雨吧",
        money: 5
    }, {
        name: "动e冻",
        money: 5
    }];
    this._init = function () {

        $(".p2").fadeIn();

        container = new createjs.Container();
        hbcontainer = new createjs.Container();


        h1 = createBitmap(s_oSpriteLibrary.getSprite('p2h1'));
        h1.x = 300;
        h1.y = 450;
        container.addChild(h1);
        h2 = createBitmap(s_oSpriteLibrary.getSprite('p2h2'));
        h2.x = 100;
        h2.y = 450;
        container.addChild(h2);

        p2end = createBitmap(s_oSpriteLibrary.getSprite('p2end'));
        p2end.x = CANVAS_WIDTH / 2;
        p2end.regX = 198;
        p2end.y = 900;
        p2end.scaleX = 0.4;
        p2end.scaleY = 0.4;
        container.addChild(p2end);

        var hbd = {
            images: [s_oSpriteLibrary.getSprite('hb')],
            frames: {width: 200, height: 273, spacing: 0},
            framerate: 10,
            animations: {
                stand: 1,
                run: [0, 1]
            }
        };
        var hbds = new createjs.SpriteSheet(hbd);
        hbdsa = new createjs.Sprite(hbds, "run");
        hbcontainer.x = CANVAS_WIDTH / 2;
        hbcontainer.y = 800;
        hbcontainer.scaleX = 0.5;
        hbcontainer.scaleY = 0.5;
        hbcontainer.regX = 100;
        hbcontainer.width = 200;
        hbcontainer.height = 273;

        hbname = new createjs.Text("", "20px hx", "red");
        hbname.textAlign = "center";
        hbname.textBaseline = "alphabetic";
        hbname.y = 75;
        hbname.x = 100;

        hbmoney = new createjs.Text("", "60px hx", "red");
        hbmoney.textAlign = "center";
        hbmoney.textBaseline = "alphabetic";
        hbmoney.y = 130;
        hbmoney.x = 100;
        hbcontainer.addChild(hbdsa);
        hbcontainer.addChild(hbmoney);
        hbcontainer.addChild(hbname);
        container.addChild(hbcontainer);

        // hd1 = createBitmap(s_oSpriteLibrary.getSprite('p2hd1'));
        // hd1.x = 400;
        // hd1.y = 450;
        // container.addChild(hd1);
        // container.addChildAt(hd1,8);
        // hd2 = createBitmap(s_oSpriteLibrary.getSprite('p2hd2'));
        // hd2.x = 300;
        // hd2.y = 450;
        // container.addChild(hd2);
        // container.setChildIndex(hd2,9);


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
        animation.x = 750 / 2;
        animation.y = 1300;
        animation.scaleX = 0.7;
        animation.scaleY = 0.7;
        animation.regX = 750 / 2;
        animation.regY = 1093;
        container.addChild(animation);


        // createjs.Tween.get(hd, {loop: true}).to({
        //     scaleX: 1.1, scaleY: 1.1
        // }, 1000, createjs.Ease.backInOut).to({
        //     scaleX: 1, scaleY: 1
        // }, 1000, createjs.Ease.backInOut).call(function () {
        // });


        s_oStage.addChild(container);

    }
    this.change = function () {
        createjs.Tween.get(animation).to({
            scaleX: 1, scaleY: 1
        }, 1000, createjs.Ease.linear).call(function () {
            var p2cz = createBitmap(s_oSpriteLibrary.getSprite('p2cz'));
            p2cz.x = 0;
            p2cz.y = -1500;
            s_oStage.addChild(p2cz);

            var p2czt = new createjs.Text("操作卡通小人，只要集齐100元红包,\n就可以一元换购100元美食大礼包,\n分享可再获得一次换购机会.", "40px hx", "#6d2a16");
            p2czt.textAlign = "center";
            p2czt.textBaseline = "alphabetic";
            p2czt.lineHeight = 60;
            p2czt.y = -200;
            p2czt.x = 380;
            s_oStage.addChild(p2czt);
            createjs.Tween.get(p2czt).to({
                y: 750
            }, 1000, createjs.Ease.backInOut);
            createjs.Tween.get(p2cz).to({
                y: 0
            }, 700, createjs.Ease.backInOut).call(function () {

                var p2start = new CGfxButton(375, 1000, s_oSpriteLibrary.getSprite('p2start'));
                p2start.addEventListener(ON_MOUSE_UP, function () {
                    p2start.setVisible(false);
                    createjs.Tween.get(p2czt).to({
                        y: -1500
                    }, 1000, createjs.Ease.backInOut).call(function () {
                    });
                    createjs.Tween.get(p2cz).to({
                        y: -1500
                    }, 2000, createjs.Ease.backInOut).call(function () {
                        page2._start();
                    });

                }, this);
            });
        });
    }
    this.unload = function () {

    }

    this._start = function () {
        var rdata = {
            images: [s_oSpriteLibrary.getSprite('p2r')],
            frames: {width: 92, height: 99, spacing: 0},
            framerate: 3,
            animations: {
                stop: 0,
                an: 1
            }
        };
        var rspriteSheet = new createjs.SpriteSheet(rdata);
        r = new createjs.Sprite(rspriteSheet, "an");
        r.x = CANVAS_WIDTH - 200 - 46;
        r.y = CANVAS_HEIGHT - 250;
        r.scaleX = 0;
        r.scaleY = 0;
        r.regX = 92 / 2;
        r.regY = 99 / 2;
        container.addChild(r);

        var ldata = {
            images: [s_oSpriteLibrary.getSprite('p2l')],
            frames: {width: 92, height: 99, spacing: 0},
            framerate: 3,
            animations: {
                stop: 0,
                an: 1
            }
        };
        var lspriteSheet = new createjs.SpriteSheet(ldata);
        l = new createjs.Sprite(lspriteSheet, "stop");
        l.x = 246;
        l.y = CANVAS_HEIGHT - 250;
        l.scaleX = 0;
        l.scaleY = 0;
        l.regX = 92 / 2;
        l.regY = 99 / 2;
        container.addChild(l);

        createjs.Tween.get(r).to({
            scaleX: 1.5, scaleY: 1.5
        }, 500, createjs.Ease.backInOut);
        createjs.Tween.get(l).to({
            scaleX: 1.5, scaleY: 1.5
        }, 500, createjs.Ease.backInOut);

        var anState = 0;
        var stepNum = 0;
        l.on("pressup" , function () {
            createjs.Tween.get(l).to({
                scaleX: 1.5, scaleY: 1.5
            }, 200, createjs.Ease.backInOut);
        });
        r.on("pressup" , function () {
            createjs.Tween.get(r).to({
                scaleX: 1.5, scaleY: 1.5
            }, 200, createjs.Ease.backInOut);
        });
        l.on("mousedown", function () {
            createjs.Tween.get(l).to({
                scaleX: 1, scaleY: 1
            }, 200, createjs.Ease.backInOut);
            if (anState == 0) {
                anState = 1;
                createjs.Sound.play("run");
                l.gotoAndPlay("an");
                r.gotoAndPlay("stop");
                if (animation.framerate < 20) {
                    animation.framerate = animation.framerate + 1;
                }
                stepNum++;
                page2._end(stepNum);
            }
        });
        r.on("mousedown", function () {
            createjs.Tween.get(r).to({
                scaleX: 1, scaleY: 1
            }, 200, createjs.Ease.backInOut);
            if (anState == 1) {
                anState = 0;
                createjs.Sound.play("run");
                r.gotoAndPlay("an");
                l.gotoAndPlay("stop");
                if (animation.framerate < 20) {
                    animation.framerate = animation.framerate + 1;
                }
                stepNum++;
                page2._end(stepNum);
            }
        });
        setInterval(function () {
            if (animation.framerate > 2) {
                animation.framerate = animation.framerate - 2;
            }
        }, 1000);

        var text = ["周大生 \n 黄金每克减20元", "金伯利\n满万元,加长悍马\n作婚车", "百丽map\n100减55", "Masfer.SU\n200减100/60",
            "JNBY\n消费满1500赠送JNBY浴巾；", "adidas\n满200减80/60", "FILA\n 满200减80/60", "NIKE\n满200减80/60", "环邮国际\n抽奖赢豪华邮轮船票","New Balance\n200减50\n部分499元起"
        ];

        var ht1 = new createjs.Text("", "50px hx", "yellow");
        ht1.textAlign = "center";
        ht1.lineHeight=55;
        ht1.textBaseline = "alphabetic";
        ht1.y = 100;
        ht1.x = CANVAS_WIDTH / 2;

        container.addChild(ht1);

        snum = new createjs.Text(0, "60px hx", "red");
        snum.textAlign = "center";
        snum.textBaseline = "alphabetic";
        snum.y = 110;
        snum.x = 60;

        snumt = new createjs.Text("元", "60px hx", "red");
        snumt.textAlign = "center";
        snumt.textBaseline = "alphabetic";
        snumt.y = 110;
        snumt.x = 110;
        hb3 = createBitmap(s_oSpriteLibrary.getSprite('hb3'));
        hb3.x = 10;
        hb3.y = 10;
        container.addChild(hb3);
        container.addChild(snumt);
        container.addChild(snum);

        var t = 0;
        setInterval(function () {
            ht1.text = text[t];
            ht1.alpha = 0;
            createjs.Tween.get(ht1).to({
                alpha: 1
            }, 1000, createjs.Ease.linear);
            t++;
            if (t == 9) {
                t = 0
            }
        }, 2000);


        // createjs.Sound.play("run", {loop: -1});


        createjs.Tween.get(h1).wait(2000).to({
            y: 100
        }, 2000, createjs.Ease.linear).call(function () {
            createjs.Tween.get(h1).to({
                x: 800, alpha: 0
            }, 2000, createjs.Ease.linear).call(function () {

            })
            createjs.Tween.get(h2).to({
                y: 100
            }, 2000, createjs.Ease.linear).call(function () {
                createjs.Tween.get(h2).to({
                    x: -300, alpha: 0
                }, 2000, createjs.Ease.linear).call(function () {

                })
            })
        })

    }

    this._end = function (snum) {
        if (snum % 1 == 0) {
            if (!hbanstate) {
                console.log(hbn);
                this._hongbao();
                if (hbn > 14) {
                    hbanstate = true;
                    createjs.Tween.get(p2end).to({
                        y: 400
                    }, 2000, createjs.Ease.linear).call(function () {
                        container.removeChild(p2end);
                        container.addChild(p2end);
                        createjs.Tween.get(p2end).to({
                            y: 700, scaleX: 1, scaleY: 1
                        }, 2000, createjs.Ease.linear).call(function () {
                            animation.gotoAndPlay("stand");
                            var p3hg = createBitmap(s_oSpriteLibrary.getSprite('p3hg'));
                            p3hg.x = 49+326;
                            p3hg.y = 50;
                            p3hg.regX = 326;
                            p3hg.alpha = 0;
                            p3hg.scaleX = 0.1;
                            p3hg.scaleY = 0.1;
                            s_oStage.addChild(p3hg);
                            createjs.Tween.get(p3hg).to({
                                alpha: 1
                                , scaleX: 1,
                                scaleY: 1
                            }, 1000, createjs.Ease.backInOut).call(function () {
                                hb3.visible = false;
                                snum.visible = false;
                                snumt.visible = false;
                                var p3btn = new CGfxButton(375, 1000, s_oSpriteLibrary.getSprite('p3btn'));
                                p3btn.addEventListener(ON_MOUSE_UP, function () {
                                    huagou();
                                }, this);
                            });
                        })
                    })
                }
            }
        }
    }

    this._hongbao = function () {
        hbname.text = hongbaotext[hbn].name;
        hbmoney.text = hongbaotext[hbn].money + "元";
        if (hbn > 15) {
            return;
        }
        hbcontainer.y = 600;
        hbcontainer.x = CANVAS_WIDTH / 2;
        hbanstate = true;
        createjs.Tween.get(hbcontainer).to({
            y: 400, x: CANVAS_WIDTH / 2
        }, 100, createjs.Ease.linear).call(function () {
            container.removeChild(hbcontainer);
            container.addChild(hbcontainer);
            createjs.Tween.get(hbcontainer).to({
                y: 550, scaleX: 1, scaleY: 1
            }, 1500, createjs.Ease.backInOut).call(function () {
                createjs.Tween.get(hbcontainer).to({
                    y: 100, x: 100, scaleX: 0.01, scaleY: 0.01
                }, 500, createjs.Ease.linear).call(function () {
                    hbanstate = false;
                    snum.text = parseInt(snum.text) + hongbaotext[hbn].money;
                    hbn++;
                });
            });
        });
    }
    this._init();
    page2 = this;

}