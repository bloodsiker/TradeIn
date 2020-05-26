const FEEDBACK_BUTTON = document.getElementsByClassName("feedback")[0];
const FEED_SEND = document.getElementById("feed_send");
const BRAND_LIST = document.getElementsByClassName("brand-list")[0];
const COST_BUTTON = document.getElementsByClassName("cost")[0];
const BRAND_ITEMS = document.getElementsByClassName("brand-items")[0];
const UL_BRAND_LIST = document.getElementsByClassName("brand-list")[0];
const BRAND_SEARCH = document.getElementsByClassName("brand-search")[0];
const BRAND_SEARCH_TEXT  = document.getElementsByClassName("brand-search-text")[0];
const MODEL_LIST = document.getElementsByClassName("model-list")[0];
const MODEL_SEARCH = document.getElementsByClassName("model-search")[0];
const MODEL_SEARCH_TEXT  = document.getElementsByClassName("model-search-text")[0];
const CHANGE_COST = document.getElementsByClassName("phone_cost-change_cost")[0];
const GET_OFFERS = document.getElementsByClassName("get_offers-button")[0]
const POWER_OPTION1 = document.getElementsByClassName("power_option1")[0];
const POWER_OPTION2 = document.getElementsByClassName("power_option2")[0];
const SCREEN_OPTION1 = document.getElementsByClassName("screen_option1")[0];
const SCREEN_OPTION2 = document.getElementsByClassName("screen_option2")[0];
const FUNCTION_OPTION1 = document.getElementsByClassName("function_phone-option1")[0];
const FUNCTION_OPTION2 = document.getElementsByClassName("function_phone-option2")[0];
const SCREEN_STATE_OPTION = document.getElementsByClassName("screen_state-option")[0];
const SCREEN_STATE_OPTION1 = document.getElementsByClassName("screen_state-option1")[0];
const SCREEN_STATE_OPTION2 = document.getElementsByClassName("screen_state-option2")[0];
const SCREEN_STATE_OPTION3 = document.getElementsByClassName("screen_state-option3")[0];
const SCREEN_STATE_OPTION4 = document.getElementsByClassName("screen_state-option4")[0];
const COVER_STATE_OPTION = document.getElementsByClassName("cover_state-option")[0];
const COVER_STATE_OPTION1 = document.getElementsByClassName("cover_state-option1")[0];
const COVER_STATE_OPTION2 = document.getElementsByClassName("cover_state-option2")[0];
const COVER_STATE_OPTION3 = document.getElementsByClassName("cover_state-option3")[0];
const COVER_STATE_OPTION4 = document.getElementsByClassName("cover_state-option4")[0];
const POWER_QUESTION = document.getElementsByClassName("power_question")[0];
const SCREEN_QUESTION = document.getElementsByClassName("screen_question")[0];
const FUNCTION_PHONE_QUESTION = document.getElementsByClassName("function_phone-question")[0];
const SCREEN_STATE_QUESTION = document.getElementsByClassName("screen_state-question")[0];
const COVER_STATE_QUESTION = document.getElementsByClassName("cover_state-question")[0];
const DISABLE_OFF = document.getElementsByClassName("disabled-off");
const DISABLE_OFF_ONE = document.getElementsByClassName("disabled-off-one")[0];
const SCREEN_TITLE = document.getElementsByClassName("screen_title")[0];
const FUNCTION_PHONE_TITLE = document.getElementsByClassName("function_phone-title")[0];
const GET_BRAND = document.getElementById("brand");
const GET_MODEL = document.getElementById("model");
const GET_COST = document.getElementById("cost");
const FORM = document.getElementById("form");

BRAND_SEARCH.onclick = function () {
    MODEL_LIST.classList.remove("disabled")
    BRAND_SEARCH.value = "";
    UL_BRAND_LIST.classList.toggle("disabled");

}
MODEL_SEARCH.onclick  = function() {
    MODEL_SEARCH.value = "";
    MODEL_LIST.classList.toggle("disabled");
}

//Список
allPhoneArr = [];
 //Загрузка базы
$(function () {
    var sheetUrl = 'https://spreadsheets.google.com/feeds/cells/1VCik8gPNw_dBH8-XR0LwjpcUhm_EamHCsl5ggKNHLGw/1/public/full?alt=json';
    //Пребпазование в строчний массив
    $.getJSON(sheetUrl, function (data) {
        var results = [];
        var entries = data.feed.entry;
        var previousRow = 0;
        for (var i = 0; i < entries.length; i++) {
            var latestRow = results[results.length - 1];
            var cell = entries[i];
            var text = cell.content.$t;
            var row = cell.gs$cell.row;
            if (row > previousRow) {
                var newRow = [];
                newRow.push(text);
                results.push(newRow);
                previousRow++;
            } else {
                latestRow.push(text);
            }
        }
        handleResults(results);
        //Отправка в общий массиы
        results.map(function (el) {
            allPhoneArr.push(el);
        })
    });
})
//формирование списка только бренда устройств
function handleResults(spreadsheetArray) {
    var model = []
    var newModel = [];
    spreadsheetArray.forEach(function(el){
        model.push(el[0])
    })
    //Убираем повторяющие варианты
     var modelFilter = new Set(model);
     newModel.push(...modelFilter);
        //Создаем список в документе
    function brandSearch () {
        newModel.forEach(function(el){
            var createLi = document.createElement("li");
            createLi.className = "brand-items";
            createLi.id = el;
            createLi.innerText = (el);
            BRAND_LIST.append(createLi);
            createLi.onclick = function() {
                newResults.shift();
                BRAND_SEARCH.value = el;
                newResults.push(BRAND_SEARCH.value);
            }
        });
    }
    brandSearch();
}

//Поиск по брендам
BRAND_SEARCH.oninput = function () {
    UL_BRAND_LIST.classList.add("disabled");
    let val = this.value.trim();
    var brandItemsLi = document.querySelectorAll('.brand-list li');
    if (val != '') {
        brandItemsLi.forEach(function (elem) {
            if (elem.innerText.search(RegExp(val,"gi")) == -1) {
                elem.classList.add('hide');
                elem.innerHTML = elem.innerText;
            }
            else {
                elem.classList.remove('hide');
                let str = elem.innerText;
                elem.innerHTML = insertMark(str, elem.innerText.search(RegExp(val,"gi")), val.length);
            }
        });
    }
    else {
        brandItemsLi.forEach(function (elem) {
            elem.classList.remove('hide');
            elem.innerHTML = elem.innerText;
        });
    }
}

function insertMark(string, pos, len) {
    return string.slice(0, pos) + '<mark>' + string.slice(pos, pos + len) + '</mark>' + string.slice(pos + len);
}

var newResults = [];

//Кнопка выбора бренда
UL_BRAND_LIST.onclick = function () {
    MODEL_LIST.innerHTML = '';
    MODEL_SEARCH.value = '';


    if (newResults.length > 1) {
        newResults.shift();
    }

    if (newResults != BRAND_SEARCH.value) {
        BRAND_SEARCH_TEXT.innerText = "Выберите модель из списка!"
    } else {
        UL_BRAND_LIST.classList.remove("disabled");
        BRAND_SEARCH_TEXT.innerText = "";
        modelList();
    }
    //Передаем результат поиска
    function modelList () {
        modelListArr = [];
      allPhoneArr.filter(function(item){
          resultFilter = item[0] == newResults[0]
            if(resultFilter != false) {
                modelListArr.push(item[1])
            }
        });
        //Создаем новый список в документе для поиска модели
        function modelSearch () {
            modelListArr.forEach(function(el){
                var createLi = document.createElement("li");
                createLi.className = "model-items";
                createLi.id = el;
                createLi.innerText = (el);
                MODEL_LIST.append(createLi);
                createLi.onclick = function() {
                    selectModel.shift();
                    MODEL_SEARCH.value = el;
                    selectModel.push(MODEL_SEARCH.value);
                }

            });

        }
        MODEL_LIST.classList.add("disabled");
        modelSearch();
        MODEL_SEARCH.focus();
    }
}
//поиск по модели
MODEL_SEARCH.oninput = function () {
    MODEL_LIST.classList.add("disabled");
    let val = this.value.trim();
    var modelItemsLi = document.querySelectorAll('.model-list li');
    if (val != '') {
        modelItemsLi.forEach(function (elem) {
            if (elem.innerText.search(RegExp(val,"gi")) == -1) {
                elem.classList.add('hide');
                elem.innerHTML = elem.innerText;
            }
            else {
                elem.classList.remove('hide');
                let str = elem.innerText;
                elem.innerHTML = insertMark(str, elem.innerText.search(RegExp(val,"gi")), val.length);
            }
        });
    }
    else {
        modelItemsLi.forEach(function (elem) {
            elem.classList.remove('hide');
            elem.innerHTML = elem.innerText;
        });
    }
}
selectModel = [];

//Кнопка результата поиска модели
MODEL_LIST.onclick = function() {
    if (selectModel.length > 1) {
        selectModel.shift();
    }
    if (selectModel != MODEL_SEARCH.value) {
        MODEL_SEARCH_TEXT.innerText = "Выберите модель из списка!"
    }else {
        MODEL_LIST.classList.remove("disabled");
        MODEL_SEARCH_TEXT.innerText = ""

        sendModel();
    }
}

function sendModel(){
    var sendModelArr = [];
    allPhoneArr.filter(function(item) {
       let ModelArr = item[1] == selectModel[0];
        if (ModelArr != false) {
            sendModelArr.push(item)
        }
    })

    CHANGE_COST.innerText = sendModelArr[0][3] + " грн";

    DISABLE_OFF_ONE.classList.add("disabled");

    FUNCTION_PHONE_TITLE.classList.remove("disabled");
    SCREEN_TITLE.classList.remove("disabled");
    DISABLE_OFF[0].classList.remove("disabled");
    DISABLE_OFF[1].classList.add("disabled");
    DISABLE_OFF[2].classList.add("disabled");
    DISABLE_OFF[3].classList.add("disabled");
    DISABLE_OFF[4].classList.add("disabled");
    POWER_OPTION1.classList.remove("clickbtn");
        POWER_OPTION2.classList.remove("clickbtn");
        SCREEN_OPTION1.classList.remove("clickbtn");
        SCREEN_OPTION2.classList.remove("clickbtn");
        FUNCTION_OPTION2.classList.remove("clickbtn");
        FUNCTION_OPTION1.classList.remove("clickbtn");


    costArr.shift();
    costArr.push(sendModelArr[0]);

    selectCost()

}

let costArr = [];


function selectCost() {
    //first block
    POWER_OPTION2.onclick = function () {
         DISABLE_OFF_ONE.classList.add("disabled");
       DISABLE_OFF[3].classList.remove("disabled");
       DISABLE_OFF[4].classList.add("disabled");
       DISABLE_OFF[2].classList.add("disabled");
       DISABLE_OFF[1].classList.add("disabled");
       FUNCTION_PHONE_TITLE.classList.remove("disabled");
       SCREEN_STATE_OPTION.classList.add("enable");
        SCREEN_TITLE.classList.remove("disabled");
        POWER_OPTION2.classList.add("clickbtn");
        POWER_OPTION1.classList.remove("clickbtn");
        SCREEN_OPTION1.classList.remove("clickbtn");
        SCREEN_OPTION2.classList.remove("clickbtn");
        FUNCTION_OPTION2.classList.remove("clickbtn");
        FUNCTION_OPTION1.classList.remove("clickbtn");


    SCREEN_STATE_OPTION1.onclick = function () {
        DISABLE_OFF_ONE.classList.add("disabled");
        CHANGE_COST.innerText = costArr[0][7] + " грн";
        DISABLE_OFF[4].classList.remove("disabled");
        COVER_STATE_OPTION.classList.add("enable");
        SCREEN_STATE_OPTION.classList.remove("enable");

        COVER_STATE_OPTION1.onclick = function () {
            DISABLE_OFF_ONE.classList.remove("disabled");
            CHANGE_COST.innerText = costArr[0][7] + " грн";
            COVER_STATE_OPTION.classList.remove("enable");
        }
        COVER_STATE_OPTION2.onclick = function () {
            DISABLE_OFF_ONE.classList.remove("disabled");
            CHANGE_COST.innerText = costArr[0][7] + " грн";
            COVER_STATE_OPTION.classList.remove("enable");
        }
        COVER_STATE_OPTION3.onclick = function () {
            DISABLE_OFF_ONE.classList.add("disabled");
            CHANGE_COST.innerText = "Нажаль стан Вашого пристрою не відповідає умовам программі  Trade-in";
            COVER_STATE_OPTION.classList.remove("enable");
        }
        COVER_STATE_OPTION4.onclick = function () {
            DISABLE_OFF_ONE.classList.add("disabled");
            CHANGE_COST.innerText = "Нажаль стан Вашого пристрою не відповідає умовам программі  Trade-in";
            COVER_STATE_OPTION.classList.remove("enable");
        }

    }
    SCREEN_STATE_OPTION2.onclick = function () {
        DISABLE_OFF_ONE.classList.add("disabled");
        CHANGE_COST.innerText = costArr[0][7] + " грн";
        DISABLE_OFF[4].classList.remove("disabled")
        COVER_STATE_OPTION.classList.add("enable");
        SCREEN_STATE_OPTION.classList.remove("enable");

        COVER_STATE_OPTION1.onclick = function () {
            DISABLE_OFF_ONE.classList.remove("disabled");
            CHANGE_COST.innerText = costArr[0][7] + " грн";
            COVER_STATE_OPTION.classList.remove("enable");
        }
        COVER_STATE_OPTION2.onclick = function () {
            DISABLE_OFF_ONE.classList.remove("disabled");
            CHANGE_COST.innerText = costArr[0][7] + " грн";
            COVER_STATE_OPTION.classList.remove("enable");
        }
        COVER_STATE_OPTION3.onclick = function () {
            DISABLE_OFF_ONE.classList.add("disabled");
            CHANGE_COST.innerText = "Нажаль стан Вашого пристрою не відповідає умовам программі  Trade-in";
            COVER_STATE_OPTION.classList.remove("enable");
        }
        COVER_STATE_OPTION4.onclick = function () {
            DISABLE_OFF_ONE.classList.add("disabled");
            CHANGE_COST.innerText = "Нажаль стан Вашого пристрою не відповідає умовам программі  Trade-in";
            COVER_STATE_OPTION.classList.remove("enable");
        }
    }
    SCREEN_STATE_OPTION3.onclick = function () {
        DISABLE_OFF_ONE.classList.add("disabled");
        CHANGE_COST.innerText = "Нажаль стан Вашого пристрою не відповідає умовам программі  Trade-in";
        DISABLE_OFF[4].classList.add("disabled");
        SCREEN_STATE_OPTION.classList.remove("enable");
        COVER_STATE_OPTION.classList.remove("enable");
    }
    SCREEN_STATE_OPTION4.onclick = function () {
        DISABLE_OFF_ONE.classList.add("disabled");
        CHANGE_COST.innerText = "Нажаль стан Вашого пристрою не відповідає умовам программі  Trade-in";
        DISABLE_OFF[4].classList.add("disabled");
        SCREEN_STATE_OPTION.classList.remove("enable");
        COVER_STATE_OPTION.classList.remove("enable");
    }

    };
    POWER_OPTION1.onclick = function() {
        DISABLE_OFF_ONE.classList.add("disabled")
        CHANGE_COST.innerText = costArr[0][3] + " грн";
        DISABLE_OFF[2].classList.add("disabled");
        DISABLE_OFF[3].classList.add("disabled");
        DISABLE_OFF[4].classList.add("disabled");
        DISABLE_OFF[1].classList.remove("disabled");
        SCREEN_TITLE.classList.add("disabled");
        FUNCTION_PHONE_TITLE.classList.remove("disabled");
        SCREEN_STATE_OPTION.classList.remove("enable");
        POWER_OPTION1.classList.add("clickbtn");
        POWER_OPTION2.classList.remove("clickbtn");
        SCREEN_OPTION1.classList.remove("clickbtn");
        SCREEN_OPTION2.classList.remove("clickbtn");
        FUNCTION_OPTION2.classList.remove("clickbtn");
        FUNCTION_OPTION1.classList.remove("clickbtn");


    };
    //second block
    SCREEN_OPTION2.onclick = function () {
        DISABLE_OFF_ONE.classList.add("disabled");
        CHANGE_COST.innerText = costArr[0][6] + " грн";
        DISABLE_OFF[2].classList.remove("disabled");
        FUNCTION_PHONE_TITLE.classList.add("disabled");
        DISABLE_OFF[3].classList.add("disabled");
        DISABLE_OFF[4].classList.add("disabled");
        SCREEN_TITLE.classList.remove("disabled");
        SCREEN_OPTION2.classList.add("clickbtn");
        SCREEN_OPTION1.classList.remove("clickbtn");
        FUNCTION_OPTION2.classList.remove("clickbtn");
        FUNCTION_OPTION1.classList.remove("clickbtn");


        FUNCTION_OPTION1.onclick = function() {
            DISABLE_OFF_ONE.classList.add("disabled");
            CHANGE_COST.innerText = costArr[0][6] + " грн";
            DISABLE_OFF[3].classList.remove("disabled");
            SCREEN_STATE_OPTION.classList.add("enable");
            FUNCTION_OPTION1.classList.add("clickbtn");
        FUNCTION_OPTION2.classList.remove("clickbtn");

            SCREEN_STATE_OPTION1.onclick = function () {
                DISABLE_OFF_ONE.classList.add("disabled");
                CHANGE_COST.innerText = costArr[0][6] + " грн";
                DISABLE_OFF[4].classList.remove("disabled");
                COVER_STATE_OPTION.classList.add("enable");
                SCREEN_STATE_OPTION.classList.remove("enable");

                COVER_STATE_OPTION1.onclick = function () {
                    DISABLE_OFF_ONE.classList.remove("disabled");
                    CHANGE_COST.innerText = costArr[0][6] + " грн";
                    COVER_STATE_OPTION.classList.remove("enable");
                }
                COVER_STATE_OPTION2.onclick = function () {
                    DISABLE_OFF_ONE.classList.remove("disabled");
                    CHANGE_COST.innerText = costArr[0][6] + " грн";
                    COVER_STATE_OPTION.classList.remove("enable");
                }
                COVER_STATE_OPTION3.onclick = function () {
                    DISABLE_OFF_ONE.classList.remove("disabled");
                    CHANGE_COST.innerText = costArr[0][7] + " грн";
                    COVER_STATE_OPTION.classList.remove("enable");
                }
                COVER_STATE_OPTION4.onclick = function () {
                    DISABLE_OFF_ONE.classList.add("disabled");
                    CHANGE_COST.innerText = "Нажаль стан Вашого пристрою не відповідає умовам программі  Trade-in";
                }

            }
            SCREEN_STATE_OPTION2.onclick = function () {
                DISABLE_OFF_ONE.classList.add("disabled");
                CHANGE_COST.innerText = costArr[0][6] + " грн";
                DISABLE_OFF[4].classList.remove("disabled");
                COVER_STATE_OPTION.classList.add("enable");
                SCREEN_STATE_OPTION.classList.remove("enable");

                COVER_STATE_OPTION1.onclick = function () {
                    DISABLE_OFF_ONE.classList.remove("disabled");
                    CHANGE_COST.innerText = costArr[0][6] + " грн";
                    COVER_STATE_OPTION.classList.remove("enable");
                }
                COVER_STATE_OPTION2.onclick = function () {
                    DISABLE_OFF_ONE.classList.remove("disabled");
                    CHANGE_COST.innerText = costArr[0][6] + " грн";
                    COVER_STATE_OPTION.classList.remove("enable");
                }
                COVER_STATE_OPTION3.onclick = function () {
                    DISABLE_OFF_ONE.classList.remove("disabled");
                    CHANGE_COST.innerText = costArr[0][7] + " грн";
                     COVER_STATE_OPTION.classList.remove("enable");
                }
                COVER_STATE_OPTION4.onclick = function () {
                    DISABLE_OFF_ONE.classList.add("disabled");
                    CHANGE_COST.innerText = "Нажаль стан Вашого пристрою не відповідає умовам программі  Trade-in";
                }
            }
            SCREEN_STATE_OPTION3.onclick = function () {
                DISABLE_OFF_ONE.classList.add("disabled");
                CHANGE_COST.innerText = costArr[0][7] + " грн";
                DISABLE_OFF[4].classList.remove("disabled");
                COVER_STATE_OPTION.classList.add("enable");
                SCREEN_STATE_OPTION.classList.remove("enable");

                COVER_STATE_OPTION1.onclick = function () {
                    DISABLE_OFF_ONE.classList.remove("disabled");
                    CHANGE_COST.innerText = costArr[0][7] + " грн";
                    COVER_STATE_OPTION.classList.remove("enable");
                }
                COVER_STATE_OPTION2.onclick = function () {
                    DISABLE_OFF_ONE.classList.remove("disabled");
                    CHANGE_COST.innerText = costArr[0][7] + " грн";
                    COVER_STATE_OPTION.classList.remove("enable");
                }
                COVER_STATE_OPTION3.onclick = function () {
                    DISABLE_OFF_ONE.classList.remove("disabled");
                    CHANGE_COST.innerText = costArr[0][7] + " грн";
                    COVER_STATE_OPTION.classList.remove("enable");
                }
                COVER_STATE_OPTION4.onclick = function () {
                    DISABLE_OFF_ONE.classList.add("disabled");
                    CHANGE_COST.innerText = "Нажаль стан Вашого пристрою не відповідає умовам программі  Trade-in";
                }
            }
            SCREEN_STATE_OPTION4.onclick = function () {
                DISABLE_OFF_ONE.classList.add("disabled");
                CHANGE_COST.innerText = "Нажаль стан Вашого пристрою не відповідає умовам программі  Trade-in";
                DISABLE_OFF[4].classList.add("disabled");
                SCREEN_STATE_OPTION.classList.remove("enable");
                COVER_STATE_OPTION.classList.remove("enable");


            };

        }

        FUNCTION_OPTION2.onclick = function() {
            DISABLE_OFF_ONE.classList.add("disabled");
            CHANGE_COST.innerText = costArr[0][7] + " грн";
            DISABLE_OFF[3].classList.remove("disabled");
            SCREEN_STATE_OPTION.classList.add("enable");
            FUNCTION_OPTION2.classList.add("clickbtn");
        FUNCTION_OPTION1.classList.remove("clickbtn");

            SCREEN_STATE_OPTION1.onclick = function () {
                DISABLE_OFF_ONE.classList.remove("disabled");
                CHANGE_COST.innerText = costArr[0][7] + " грн";
                DISABLE_OFF[4].classList.add("disabled");
                COVER_STATE_OPTION.classList.add("enable");
                SCREEN_STATE_OPTION.classList.remove("enable");

                COVER_STATE_OPTION1.onclick = function () {
                    DISABLE_OFF_ONE.classList.remove("disabled");
                    CHANGE_COST.innerText = costArr[0][7] + " грн";
                    COVER_STATE_OPTION.classList.remove("enable");
                }
                COVER_STATE_OPTION2.onclick = function () {
                    DISABLE_OFF_ONE.classList.remove("disabled");
                    CHANGE_COST.innerText = costArr[0][7] + " грн";
                    COVER_STATE_OPTION.classList.remove("enable");
                }
                COVER_STATE_OPTION3.onclick = function () {
                    DISABLE_OFF_ONE.classList.remove("disabled");
                    CHANGE_COST.innerText = costArr[0][7] + " грн";
                    COVER_STATE_OPTION.classList.remove("enable");
                }
                COVER_STATE_OPTION4.onclick = function () {
                    DISABLE_OFF_ONE.classList.add("disabled");
                    CHANGE_COST.innerText = "Нажаль стан Вашого пристрою не відповідає умовам программі  Trade-in";
                }

            }
            SCREEN_STATE_OPTION2.onclick = function () {
                DISABLE_OFF_ONE.classList.remove("disabled");
                CHANGE_COST.innerText = costArr[0][7] + " грн";
                DISABLE_OFF[4].classList.add("disabled");
                COVER_STATE_OPTION.classList.add("enable");
                SCREEN_STATE_OPTION.classList.remove("enable");

                COVER_STATE_OPTION1.onclick = function () {
                    DISABLE_OFF_ONE.classList.remove("disabled");
                    CHANGE_COST.innerText = costArr[0][7] + " грн";
                    COVER_STATE_OPTION.classList.remove("enable");
                }
                COVER_STATE_OPTION2.onclick = function () {
                    DISABLE_OFF_ONE.classList.remove("disabled");
                    CHANGE_COST.innerText = costArr[0][7] + " грн";
                    COVER_STATE_OPTION.classList.remove("enable");
                }
                COVER_STATE_OPTION3.onclick = function () {
                    DISABLE_OFF_ONE.classList.remove("disabled");
                    CHANGE_COST.innerText = costArr[0][7] + " грн";
                    COVER_STATE_OPTION.classList.remove("enable");
                }
                COVER_STATE_OPTION4.onclick = function () {
                    DISABLE_OFF_ONE.classList.add("disabled");
                    CHANGE_COST.innerText = "Нажаль стан Вашого пристрою не відповідає умовам программі  Trade-in";
                }
            }
            SCREEN_STATE_OPTION3.onclick = function () {
                DISABLE_OFF_ONE.classList.remove("disabled");
                CHANGE_COST.innerText = costArr[0][7] + " грн";
                DISABLE_OFF[4].classList.add("disabled");
                COVER_STATE_OPTION.classList.add("enable");
                SCREEN_STATE_OPTION.classList.remove("enable");

                COVER_STATE_OPTION1.onclick = function () {
                    DISABLE_OFF_ONE.classList.remove("disabled");
                    CHANGE_COST.innerText = costArr[0][7] + " грн";
                    COVER_STATE_OPTION.classList.remove("enable");
                }
                COVER_STATE_OPTION2.onclick = function () {
                    DISABLE_OFF_ONE.classList.remove("disabled");
                    CHANGE_COST.innerText = costArr[0][7] + " грн";
                    COVER_STATE_OPTION.classList.remove("enable");
                }
                COVER_STATE_OPTION3.onclick = function () {
                    DISABLE_OFF_ONE.classList.remove("disabled");
                    CHANGE_COST.innerText = costArr[0][7] + " грн";
                    COVER_STATE_OPTION.classList.remove("enable");
                }
                COVER_STATE_OPTION4.onclick = function () {
                    DISABLE_OFF_ONE.classList.add("disabled");
                    CHANGE_COST.innerText = "Нажаль стан Вашого пристрою не відповідає умовам программі  Trade-in";
                }
            }
            SCREEN_STATE_OPTION4.onclick = function () {
                DISABLE_OFF_ONE.classList.add("disabled");
                CHANGE_COST.innerText = "Нажаль стан Вашого пристрою не відповідає умовам программі  Trade-in";
                DISABLE_OFF[4].classList.add("disabled");
                SCREEN_STATE_OPTION.classList.remove("enable");
                COVER_STATE_OPTION.classList.remove("enable");
            };
        }

    }
    SCREEN_OPTION1.onclick = function() {
        DISABLE_OFF_ONE.classList.add("disabled");
        CHANGE_COST.innerText = costArr[0][3] + " грн";
        DISABLE_OFF[2].classList.remove("disabled");
        FUNCTION_PHONE_TITLE.classList.add("disabled");
        DISABLE_OFF[3].classList.add("disabled");
        DISABLE_OFF[4].classList.add("disabled");
        SCREEN_TITLE.classList.remove("disabled");
        SCREEN_OPTION1.classList.add("clickbtn");
        SCREEN_OPTION2.classList.remove("clickbtn");
        FUNCTION_OPTION2.classList.remove("clickbtn");
        FUNCTION_OPTION1.classList.remove("clickbtn");
    }
    //third block
    FUNCTION_OPTION2.onclick = function() {
        DISABLE_OFF_ONE.classList.add("disabled");
        CHANGE_COST.innerText = costArr[0][6] + " грн";
        DISABLE_OFF[3].classList.remove("disabled");
        DISABLE_OFF[4].classList.add("disabled");
        SCREEN_STATE_OPTION.classList.add("enable");
        FUNCTION_PHONE_TITLE.classList.remove("disabled");
        FUNCTION_OPTION2.classList.add("clickbtn");
        FUNCTION_OPTION1.classList.remove("clickbtn");

        SCREEN_STATE_OPTION1.onclick = function () {
            DISABLE_OFF_ONE.classList.add("disabled");
            CHANGE_COST.innerText = costArr[0][6] + " грн";
            DISABLE_OFF[4].classList.remove("disabled");
            COVER_STATE_OPTION.classList.add("enable");
            SCREEN_STATE_OPTION.classList.remove("enable");

            COVER_STATE_OPTION1.onclick = function () {
                DISABLE_OFF_ONE.classList.remove("disabled");
                CHANGE_COST.innerText = costArr[0][6] + " грн";
                COVER_STATE_OPTION.classList.remove("enable");
            }
            COVER_STATE_OPTION2.onclick = function () {
                DISABLE_OFF_ONE.classList.remove("disabled");
                CHANGE_COST.innerText = costArr[0][6] + " грн";
             COVER_STATE_OPTION.classList.remove("enable");
            }
            COVER_STATE_OPTION3.onclick = function () {
                DISABLE_OFF_ONE.classList.remove("disabled");
                CHANGE_COST.innerText = costArr[0][7] + " грн";
                COVER_STATE_OPTION.classList.remove("enable");
            }
            COVER_STATE_OPTION4.onclick = function () {
                DISABLE_OFF_ONE.classList.add("disabled");
                CHANGE_COST.innerText = "Нажаль стан Вашого пристрою не відповідає умовам программі  Trade-in";
            }

        }
        SCREEN_STATE_OPTION2.onclick = function () {
            DISABLE_OFF_ONE.classList.add("disabled");
            CHANGE_COST.innerText = costArr[0][6] + " грн";
            DISABLE_OFF[4].classList.remove("disabled");
            COVER_STATE_OPTION.classList.add("enable");
            SCREEN_STATE_OPTION.classList.remove("enable");

            COVER_STATE_OPTION1.onclick = function () {
                DISABLE_OFF_ONE.classList.remove("disabled");
                CHANGE_COST.innerText = costArr[0][6] + " грн";
                COVER_STATE_OPTION.classList.remove("enable");
            }
            COVER_STATE_OPTION2.onclick = function () {
                DISABLE_OFF_ONE.classList.remove("disabled");
                CHANGE_COST.innerText = costArr[0][6] + " грн";
                COVER_STATE_OPTION.classList.remove("enable");
            }
            COVER_STATE_OPTION3.onclick = function () {
                DISABLE_OFF_ONE.classList.remove("disabled");
                CHANGE_COST.innerText = costArr[0][7] + " грн";
                COVER_STATE_OPTION.classList.remove("enable");
            }
            COVER_STATE_OPTION4.onclick = function () {
                DISABLE_OFF_ONE.classList.add("disabled");
                CHANGE_COST.innerText = "Нажаль стан Вашого пристрою не відповідає умовам программі  Trade-in";
            }
        }
        SCREEN_STATE_OPTION3.onclick = function () {
            DISABLE_OFF_ONE.classList.add("disabled");
            CHANGE_COST.innerText = costArr[0][7] + " грн";
            DISABLE_OFF[4].classList.remove("disabled");
            COVER_STATE_OPTION.classList.add("enable");
            SCREEN_STATE_OPTION.classList.remove("enable");

            COVER_STATE_OPTION1.onclick = function () {
                DISABLE_OFF_ONE.classList.remove("disabled");
                CHANGE_COST.innerText = costArr[0][7] + " грн";
                COVER_STATE_OPTION.classList.remove("enable");
            }
            COVER_STATE_OPTION2.onclick = function () {
                DISABLE_OFF_ONE.classList.remove("disabled");
                CHANGE_COST.innerText = costArr[0][7] + " грн";
                COVER_STATE_OPTION.classList.remove("enable");

            }
            COVER_STATE_OPTION3.onclick = function () {
                DISABLE_OFF_ONE.classList.remove("disabled");
                CHANGE_COST.innerText = costArr[0][7] + " грн";
                COVER_STATE_OPTION.classList.remove("enable");
            }
            COVER_STATE_OPTION4.onclick = function () {
                DISABLE_OFF_ONE.classList.add("disabled");
                CHANGE_COST.innerText = "Нажаль стан Вашого пристрою не відповідає умовам программі  Trade-in";
            }
        }
        SCREEN_STATE_OPTION4.onclick = function () {
            DISABLE_OFF_ONE.classList.add("disabled");
            CHANGE_COST.innerText = "Нажаль стан Вашого пристрою не відповідає умовам программі  Trade-in";
            DISABLE_OFF[4].classList.add("disabled");
            SCREEN_STATE_OPTION.classList.remove("enable");
            COVER_STATE_OPTION.classList.remove("enable");
        };
    }
    FUNCTION_OPTION1.onclick = function() {
        DISABLE_OFF_ONE.classList.add("disabled");
        CHANGE_COST.innerText = costArr[0][3] + " грн";
        DISABLE_OFF[3].classList.remove("disabled");
        DISABLE_OFF[4].classList.add("disabled");
        SCREEN_STATE_OPTION.classList.add("enable");
        FUNCTION_PHONE_TITLE.classList.remove("disabled");
        FUNCTION_OPTION1.classList.add("clickbtn");
        FUNCTION_OPTION2.classList.remove("clickbtn");

        SCREEN_STATE_OPTION1.onclick = function () {
            DISABLE_OFF_ONE.classList.add("disabled");
            CHANGE_COST.innerText = costArr[0][3] + " грн";
            DISABLE_OFF[4].classList.remove("disabled");
            COVER_STATE_OPTION.classList.add("enable");
            SCREEN_STATE_OPTION.classList.remove("enable");
            coverSt1();
        }
        SCREEN_STATE_OPTION2.onclick = function () {
            DISABLE_OFF_ONE.classList.add("disabled");
            CHANGE_COST.innerText = costArr[0][4] + " грн";
            DISABLE_OFF[4].classList.remove("disabled");
            COVER_STATE_OPTION.classList.add("enable");
            SCREEN_STATE_OPTION.classList.remove("enable");
            coverSt2();
        }
        SCREEN_STATE_OPTION3.onclick = function () {
            DISABLE_OFF_ONE.classList.add("disabled");
            CHANGE_COST.innerText = costArr[0][5] + " грн";
            DISABLE_OFF[4].classList.remove("disabled");
            COVER_STATE_OPTION.classList.add("enable");
            SCREEN_STATE_OPTION.classList.remove("enable");
            coverSt3()
        }
        SCREEN_STATE_OPTION4.onclick = function () {
            DISABLE_OFF_ONE.classList.remove("disabled");
            CHANGE_COST.innerText = costArr[0][6] + " грн";
            SCREEN_STATE_OPTION.classList.remove("enable");
        }


        function coverSt1() {
            COVER_STATE_OPTION1.onclick = function () {
                DISABLE_OFF_ONE.classList.remove("disabled");
                CHANGE_COST.innerText = costArr[0][3] + " грн";
                COVER_STATE_OPTION.classList.remove("enable");
            }
            COVER_STATE_OPTION2.onclick = function () {
                DISABLE_OFF_ONE.classList.remove("disabled");
                CHANGE_COST.innerText = costArr[0][4] + " грн";
                COVER_STATE_OPTION.classList.remove("enable");
            }
            COVER_STATE_OPTION3.onclick = function () {
                DISABLE_OFF_ONE.classList.remove("disabled");
                CHANGE_COST.innerText = costArr[0][4] + " грн";
                COVER_STATE_OPTION.classList.remove("enable");
            }
            COVER_STATE_OPTION4.onclick = function () {
                DISABLE_OFF_ONE.classList.remove("disabled");
                CHANGE_COST.innerText = costArr[0][5] + " грн";
                COVER_STATE_OPTION.classList.remove("enable");
            }
        }

        function coverSt2() {
            COVER_STATE_OPTION1.onclick = function () {
                DISABLE_OFF_ONE.classList.remove("disabled");
                CHANGE_COST.innerText = costArr[0][4] + " грн";
                COVER_STATE_OPTION.classList.remove("enable");
            }
            COVER_STATE_OPTION2.onclick = function () {
                DISABLE_OFF_ONE.classList.remove("disabled");
                CHANGE_COST.innerText = costArr[0][4] + " грн";
                COVER_STATE_OPTION.classList.remove("enable");
            }
            COVER_STATE_OPTION3.onclick = function () {
                DISABLE_OFF_ONE.classList.remove("disabled");
                CHANGE_COST.innerText = costArr[0][5] + " грн";
                COVER_STATE_OPTION.classList.remove("enable");
            }
            COVER_STATE_OPTION4.onclick = function () {
                DISABLE_OFF_ONE.classList.remove("disabled");
                CHANGE_COST.innerText = costArr[0][5] + " грн";
                COVER_STATE_OPTION.classList.remove("enable");
            }
        }

        function coverSt3() {
            COVER_STATE_OPTION1.onclick = function () {
                DISABLE_OFF_ONE.classList.remove("disabled");
                CHANGE_COST.innerText = costArr[0][5] + " грн";
                COVER_STATE_OPTION.classList.remove("enable");
            }
            COVER_STATE_OPTION2.onclick = function () {
                DISABLE_OFF_ONE.classList.remove("disabled");
                CHANGE_COST.innerText = costArr[0][5] + " грн";
                COVER_STATE_OPTION.classList.remove("enable");
            }
            COVER_STATE_OPTION3.onclick = function () {
                DISABLE_OFF_ONE.classList.remove("disabled");
                CHANGE_COST.innerText = costArr[0][5] + " грн";
                COVER_STATE_OPTION.classList.remove("enable");
            }
            COVER_STATE_OPTION4.onclick = function () {
                DISABLE_OFF_ONE.classList.remove("disabled");
                CHANGE_COST.innerText = costArr[0][6] + " грн";
                COVER_STATE_OPTION.classList.remove("enable");
            }
        }

    }
    //fourth block


}
SCREEN_STATE_QUESTION.onclick = function () {
    SCREEN_STATE_OPTION.classList.toggle("enable")
}

COVER_STATE_QUESTION.onclick = function () {
    COVER_STATE_OPTION.classList.toggle("enable")
}

GET_OFFERS.onclick = function () {
    GET_MODEL.value = MODEL_SEARCH.value;
    GET_BRAND.value = BRAND_SEARCH.value;
    GET_COST.value = CHANGE_COST.textContent;
}

FEED_SEND.onclick = function(e) {
    e.preventDefault();

    let _form = $('#form');

    $.ajax({
        type: _form.attr('method'),
        url: _form.attr('action'),
        data: _form.serializeArray(),
    }).done(function(response) {
        console.log(response);

        // function reloadPage() {
        //     location.reload();
        // }
        // setTimeout(reloadPage, 2000);
        // $("#form").trigger("reset");
    });
}



