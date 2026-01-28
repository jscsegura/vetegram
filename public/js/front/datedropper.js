($.dateDropperSetup = {
    languages: {
        en: {
            name: "English",
            months: {
                short: ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec"],
                full: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            },
            weekdays: { short: ["S", "M", "T", "W", "T", "F", "S"], full: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"] },
        },
        ka: {
            name: "Georgian",
            months: {
                short: ["იან", "თებ", "მარტ", "აპრ", "მაი", "ივნ", "ივლ", "აგვ", "სექტ", "ოქტ", "ნოემბ", "დეკ"],
                full: ["იანვარი", "თებერვალი", "მარტი", "აპრილი", "მაისი", "ივნისი", "ივლისი", "აგვისტო", "სექტემბერი", "ოქტომბერი", "ნოემბერი", "დეკემბერი"],
            },
            weekdays: { short: ["კვ", "ორ", "სამ", "ოთხ", "ხუთ", "პარ", "შაბ"], full: ["კვირა", "ორშაბათი", "სამშაბათი", "ოთხშაბათი", "ხუთშაბათი", "პარასკევი", "შაბათი"] },
        },
        it: {
            name: "Italiano",
            months: {
                short: ["Gen", "Feb", "Mar", "Apr", "Mag", "Giu", "Lug", "Ago", "Set", "Ott", "Nov", "Dic"],
                full: ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"],
            },
            weekdays: { short: ["D", "L", "M", "M", "G", "V", "S"], full: ["Domenica", "Lunedì", "Martedì", "Mercoledì", "Giovedì", "Venerdì", "Sabato"] },
        },
        fr: {
            name: "Français",
            months: {
                short: ["Jan", "Fév", "Mar", "Avr", "Mai", "Jui", "Jui", "Aoû", "Sep", "Oct", "Nov", "Déc"],
                full: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
            },
            weekdays: { short: ["D", "L", "M", "M", "J", "V", "S"], full: ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"] },
        },
        zh: {
            name: "中文",
            months: { short: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"], full: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"] },
            weekdays: { short: ["天", "一", "二", "三", "四", "五", "六"], full: ["星期天", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"] },
        },
        ar: {
            name: "العَرَبِيَّة",
            months: {
                short: ["جانفي", "فيفري", "مارس", "أفريل", "ماي", "جوان", "جويلية", "أوت", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"],
                full: ["جانفي", "فيفري", "مارس", "أفريل", "ماي", "جوان", "جويلية", "أوت", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"],
            },
            weekdays: { short: ["S", "M", "T", "W", "T", "F", "S"], full: ["الأحد", "الإثنين", "الثلثاء", "الأربعاء", "الخميس", "الجمعة", "السبت"] },
        },
        fa: {
            name: "فارسی",
            months: {
                short: ["ژانویه", "فووریه", "مارچ", "آپریل", "می", "جون", "جولای", "آگوست", "سپتامبر", "اکتبر", "نوامبر", "دسامبر"],
                full: ["ژانویه", "فووریه", "مارچ", "آپریل", "می", "جون", "جولای", "آگوست", "سپتامبر", "اکتبر", "نوامبر", "دسامبر"],
            },
            weekdays: { short: ["S", "M", "T", "W", "T", "F", "S"], full: ["یکشنبه", "دوشنبه", "سه شنبه", "چهارشنبه", "پنج شنبه", "جمعه", "شنبه"] },
        },
        hu: {
            name: "Hungarian",
            months: {
                short: ["jan", "feb", "már", "ápr", "máj", "jún", "júl", "aug", "sze", "okt", "nov", "dec"],
                full: ["január", "február", "március", "április", "május", "június", "július", "augusztus", "szeptember", "október", "november", "december"],
            },
            weekdays: { short: ["v", "h", "k", "s", "c", "p", "s"], full: ["vasárnap", "hétfő", "kedd", "szerda", "csütörtök", "péntek", "szombat"] },
        },
        gr: {
            name: "Ελληνικά",
            months: {
                short: ["Ιαν", "Φεβ", "Μάρ", "Απρ", "Μάι", "Ιούν", "Ιούλ", "Αύγ", "Σεπ", "Οκτ", "Νοέ", "Δεκ"],
                full: ["Ιανουάριος", "Φεβρουάριος", "Μάρτιος", "Απρίλιος", "Μάιος", "Ιούνιος", "Ιούλιος", "Αύγουστος", "Σεπτέμβριος", "Οκτώβριος", "Νοέμβριος", "Δεκέμβριος"],
            },
            weekdays: { short: ["Κ", "Δ", "Τ", "Τ", "Π", "Π", "Σ"], full: ["Κυριακή", "Δευτέρα", "Τρίτη", "Τετάρτη", "Πέμπτη", "Παρασκευή", "Σάββατο"] },
        },
        es: {
            name: "Español",
            months: {
                short: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                full: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
            },
            weekdays: { short: ["D", "L", "M", "X", "J", "V", "S"], full: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"] },
        },
        da: {
            name: "Dansk",
            months: {
                short: ["jan", "feb", "mar", "apr", "maj", "jun", "jul", "aug", "sep", "okt", "nov", "dec"],
                full: ["januar", "februar", "marts", "april", "maj", "juni", "juli", "august", "september", "oktober", "november", "december"],
            },
            weekdays: { short: ["s", "m", "t", "o", "t", "f", "l"], full: ["søndag", "mandag", "tirsdag", "onsdag", "torsdag", "fredag", "lørdag"] },
        },
        de: {
            name: "Deutsch",
            months: {
                short: ["Jan", "Feb", "Mär", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez"],
                full: ["Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"],
            },
            weekdays: { short: ["S", "M", "D", "M", "D", "F", "S"], full: ["Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag"] },
        },
        nl: {
            name: "Nederlands",
            months: {
                short: ["jan", "feb", "maa", "apr", "mei", "jun", "jul", "aug", "sep", "okt", "nov", "dec"],
                full: ["januari", "februari", "maart", "april", "mei", "juni", "juli", "augustus", "september", "oktober", "november", "december"],
            },
            weekdays: { short: ["z", "m", "d", "w", "d", "v", "z"], full: ["zondag", "maandag", "dinsdag", "woensdag", "donderdag", "vrijdag", "zaterdag"] },
        },
        pl: {
            name: "język polski",
            months: {
                short: ["sty", "lut", "mar", "kwi", "maj", "cze", "lip", "sie", "wrz", "paź", "lis", "gru"],
                full: ["styczeń", "luty", "marzec", "kwiecień", "maj", "czerwiec", "lipiec", "sierpień", "wrzesień", "październik", "listopad", "grudzień"],
            },
            weekdays: { short: ["n", "p", "w", "ś", "c", "p", "s"], full: ["niedziela", "poniedziałek", "wtorek", "środa", "czwartek", "piątek", "sobota"] },
        },
        pt: {
            name: "Português",
            months: {
                short: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
                full: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
            },
            weekdays: { short: ["D", "S", "T", "Q", "Q", "S", "S"], full: ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"] },
        },
        si: {
            name: "Slovenščina",
            months: {
                short: ["jan", "feb", "mar", "apr", "maj", "jun", "jul", "avg", "sep", "okt", "nov", "dec"],
                full: ["januar", "februar", "marec", "april", "maj", "junij", "julij", "avgust", "september", "oktober", "november", "december"],
            },
            weekdays: { short: ["n", "p", "t", "s", "č", "p", "s"], full: ["nedelja", "ponedeljek", "torek", "sreda", "četrtek", "petek", "sobota"] },
        },
        uk: {
            name: "українська мова",
            months: {
                short: ["січень", "лютий", "березень", "квітень", "травень", "червень", "липень", "серпень", "вересень", "жовтень", "листопад", "грудень"],
                full: ["січень", "лютий", "березень", "квітень", "травень", "червень", "липень", "серпень", "вересень", "жовтень", "листопад", "грудень"],
            },
            weekdays: { short: ["н", "п", "в", "с", "ч", "п", "с"], full: ["неділя", "понеділок", "вівторок", "середа", "четвер", "п'ятниця", "субота"] },
        },
        ru: {
            name: "русский язык",
            months: {
                short: ["январь", "февраль", "март", "апрель", "май", "июнь", "июль", "август", "сентябрь", "октябрь", "ноябрь", "декабрь"],
                full: ["январь", "февраль", "март", "апрель", "май", "июнь", "июль", "август", "сентябрь", "октябрь", "ноябрь", "декабрь"],
            },
            weekdays: { short: ["в", "п", "в", "с", "ч", "п", "с"], full: ["воскресенье", "понедельник", "вторник", "среда", "четверг", "пятница", "суббота"] },
        },
        tr: {
            name: "Türkçe",
            months: { short: ["Oca", "Şub", "Mar", "Nis", "May", "Haz", "Tem", "Ağu", "Eyl", "Eki", "Kas", "Ara"], full: ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"] },
            weekdays: { short: ["P", "P", "S", "Ç", "P", "C", "C"], full: ["Pazar", "Pazartesi", "Sali", "Çarşamba", "Perşembe", "Cuma", "Cumartesi"] },
        },
        ko: {
            name: "조선말",
            months: { short: ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"], full: ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"] },
            weekdays: { short: ["일", "월", "화", "수", "목", "금", "토"], full: ["일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일"] },
        },
        fi: {
            name: "suomen kieli",
            months: {
                short: ["Tam", "Hel", "Maa", "Huh", "Tou", "Kes", "Hei", "Elo", "Syy", "Lok", "Mar", "Jou"],
                full: ["Tammikuu", "Helmikuu", "Maaliskuu", "Huhtikuu", "Toukokuu", "Kesäkuu", "Heinäkuu", "Elokuu", "Syyskuu", "Lokakuu", "Marraskuu", "Joulukuu"],
            },
            weekdays: { short: ["S", "M", "T", "K", "T", "P", "L"], full: ["Sunnuntai", "Maanantai", "Tiistai", "Keskiviikko", "Torstai", "Perjantai", "Lauantai"] },
        },
        vi: {
            name: "Tiếng việt",
            gregorian: !1,
            months: {
                short: ["Th.01", "Th.02", "Th.03", "Th.04", "Th.05", "Th.06", "Th.07", "Th.08", "Th.09", "Th.10", "Th.11", "Th.12"],
                full: ["Tháng 01", "Tháng 02", "Tháng 03", "Tháng 04", "Tháng 05", "Tháng 06", "Tháng 07", "Tháng 08", "Tháng 09", "Tháng 10", "Tháng 11", "Tháng 12"],
            },
            weekdays: { short: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"], full: ["Chủ nhật", "Thứ hai", "Thứ ba", "Thứ tư", "Thứ năm", "Thứ sáu", "Thứ bảy"] },
        },
    },
    icons: {
        arrow: {
            l: '<svg viewBox="0 -1 6 16" height="14" width="8"><polyline points="6 0 0 6 6 12" stroke="currentColor" stroke-width="2" fill="none"></polyline></svg>',
            r: '<svg viewBox="6 -1 6 16" height="14" width="8"><polyline points="6 0 12 6 6 12" stroke="currentColor" stroke-width="2" fill="none"></polyline></svg>',
        },
        checkmark: '<svg viewBox="0 0 22 18" height="18" width="32"><polyline points="0 8 8 16 22 1" stroke="currentColor" stroke-width="2" fill="none" ></polyline></svg>',
        expand:
            '<svg width="18" height="18" viewBox="0 -3 12 18" stroke="currentColor" stroke-width="1.5" fill="none"><polyline points="8 0 12 0 12 4" fill="none"></polyline><path d="M11.4444444,0.555555556 L6.97196343,5.02803657" stroke-linecap="square"></path><path d="M5.5,6.5 L0.555555556,11.4444444" stroke-linecap="square"></path><polyline points="0 8 0 12 4 12" fill="none"></polyline></svg>',
    },
    autoInit: !0,
    inlineCSS:
        '.picker-input{cursor:text}.picker-overlay{position:fixed;top:0;left:0;width:100%;height:100%;background-color:rgba(0,0,0,0.8);z-index:2147483637;opacity:1;visibility:visible;transition:opacity 0.4s ease,visibility 0.4s ease}.picker-overlay.picker-overlay-hidden{opacity:0;visibility:hidden}div.datedropper{--dd-color1:#fd4741;--dd-color2:white;--dd-color3:#4D4D4D;--dd-color4:white;--dd-radius:6px;--dd-width:180px;--dd-shadow:0 0 32px 0 rgba(0,0,0,0.1);touch-action:none;position:absolute;top:0;left:0;z-index:2147483638;transform:translate3d(-50%,0,0);line-height:1;font-family:sans-serif;box-sizing:border-box;-webkit-user-select:none;user-select:none;-webkit-tap-highlight-color:rgba(0,0,0,0);opacity:0;visibility:hidden;margin-top:-8px;-webkit-backface-visibility:hidden;backface-visibility:hidden;border-radius:6px!important;border-radius:var(--dd-radius)!important}div.datedropper.leaf{--dd-color1:#1ecd80;--dd-color2:#fefff2;--dd-color3:#528971;--dd-color4:#fefff2;--dd-radius:6px;--dd-width:180px;--dd-shadow:0 0 32px 0 rgba(0,0,0,0.1)}div.datedropper.vanilla{--dd-color1:#feac92;--dd-color2:#FFF;--dd-color3:#9ed7db;--dd-color4:#faf7f4;--dd-radius:6px;--dd-width:180px;--dd-shadow:0 0 32px 0 rgba(0,0,0,0.1)}div.datedropper.ryanair{--dd-color1:#7e57dc;--dd-color2:#50388a;--dd-color3:#ffffff;--dd-color4:#FFF;--dd-radius:6px;--dd-width:180px;--dd-shadow:0 0 32px 0 rgba(0,0,0,0.1)}@media only screen and (max-width:479px){div.datedropper{position:fixed;top:50%!important;left:50%!important;transform:translate3d(-50%,-50%,0);margin:0}div.datedropper:before{display:none}div.datedropper .picker{box-shadow:0 0 64px 32px rgba(0,0,0,0.06)!important}}div.datedropper *{box-sizing:border-box;width:auto;height:auto;margin:0;padding:0;border:0;font-size:100%}div.datedropper svg{fill:currentColor}div.datedropper:before{content:"";position:absolute;width:16px;height:16px;top:-8px;left:50%;transform:translateX(-50%) rotate(45deg);border-top-left-radius:4px;background-color:white;z-index:1}div.datedropper.picker-focused{opacity:1;visibility:visible;margin-top:8px}@media only screen and (max-width:479px){div.datedropper.picker-focused{margin-top:0}}div.datedropper .pick-submit{margin:0 auto;outline:0;width:56px;height:100%;line-height:64px;border-radius:56px;font-size:24px;cursor:pointer;border-bottom-left-radius:0;border-bottom-right-radius:0;text-align:center;position:relative;top:0}div.datedropper .pick-submit:focus,div.datedropper .pick-submit:hover{top:4px;box-shadow:0 0 0 16px rgba(0,0,0,0.04),0 0 0 8px rgba(0,0,0,0.04)}div.datedropper .pick-submit svg{position:relative;top:20px}div.datedropper .picker{position:relative;overflow:hidden}div.datedropper .picker+div{font-weight:bold;font-size:10px;text-transform:uppercase;padding:0.5rem;text-align:center}div.datedropper .picker+div a{text-decoration:none;color:currentColor}div.datedropper .picker+div a:hover{text-decoration:underline}div.datedropper .picker ul{margin:0;padding:0;list-style:none;cursor:pointer;position:relative;z-index:2}div.datedropper .picker ul.pick{position:relative;overflow:hidden;outline:0}div.datedropper .picker ul.pick:nth-of-type(2){box-shadow:0 1px rgba(0,0,0,0.06)}div.datedropper .picker ul.pick li{position:absolute;top:0;left:0;width:100%;height:100%;text-align:center;opacity:0.5;display:flex;align-items:center;justify-content:center;text-align:center;pointer-events:none}div.datedropper .picker ul.pick li span{font-size:16px;position:absolute;left:0;width:100%;line-height:0;bottom:24px}div.datedropper .picker ul.pick li.pick-afr{transform:translateY(100%)}div.datedropper .picker ul.pick li.pick-bfr{transform:translateY(-100%)}div.datedropper .picker ul.pick li.pick-sl{opacity:1;transform:translateY(0);z-index:1;pointer-events:auto}div.datedropper .picker ul.pick:focus .pick-arw-s1:not(.pick-arw-hidden),div.datedropper .picker ul.pick:hover .pick-arw-s1:not(.pick-arw-hidden){opacity:0.6}div.datedropper .picker ul.pick:focus.pick-jump .pick-arw-s2,div.datedropper .picker ul.pick:hover.pick-jump .pick-arw-s2{pointer-events:auto;opacity:0.6}div.datedropper .picker ul.pick:focus.pick-jump .pick-arw-s2.pick-arw-r,div.datedropper .picker ul.pick:hover.pick-jump .pick-arw-s2.pick-arw-r{transform:translateX(-8px)}div.datedropper .picker ul.pick:focus.pick-jump .pick-arw-s2.pick-arw-l,div.datedropper .picker ul.pick:hover.pick-jump .pick-arw-s2.pick-arw-l{transform:translateX(8px)}div.datedropper .picker ul.pick .pick-arw{position:absolute;top:0;height:100%;width:25%;font-size:10px;text-align:center;display:block;z-index:10;cursor:pointer;overflow:hidden;opacity:0}div.datedropper .picker ul.pick .pick-arw div{line-height:0;top:50%;left:50%;position:absolute;display:block;transform:translate(-50%,-50%)}div.datedropper .picker ul.pick .pick-arw svg{width:16px;height:16px}div.datedropper .picker ul.pick .pick-arw-hidden{opacity:0;pointer-events:none}div.datedropper .picker ul.pick .pick-arw.pick-arw:hover{opacity:1}div.datedropper .picker ul.pick .pick-arw.pick-arw-r{right:0}div.datedropper .picker ul.pick .pick-arw.pick-arw-l{left:0}div.datedropper .picker ul.pick .pick-arw.pick-arw-s2{pointer-events:none}div.datedropper .picker ul.pick .pick-arw.pick-arw-s2.pick-arw-r{transform:translateX(0)}div.datedropper .picker ul.pick .pick-arw.pick-arw-s2.pick-arw-l{transform:translateX(0)}div.datedropper .picker ul.pick.pick-m,div.datedropper .picker ul.pick.pick-y{height:60px}div.datedropper .picker ul.pick.pick-m{font-size:32px}div.datedropper .picker ul.pick.pick-y{font-size:24px}div.datedropper .picker ul.pick.pick-d{height:100px;font-size:64px;font-weight:bold}div.datedropper .picker ul.pick.pick-d li div{margin-top:-16px}div.datedropper .picker ul.pick:focus:after,div.datedropper .picker ul.pick:hover:after{content:"";pointer-events:none;position:absolute;top:6px;left:6px;bottom:6px;right:6px;background-color:rgba(0,0,0,0.04);border-radius:6px}div.datedropper .picker .pick-lg{z-index:1;margin:0 auto;height:0;overflow:hidden}div.datedropper .picker .pick-lg.pick-lg-focused{background-color:rgba(0,0,0,0.025)}div.datedropper .picker .pick-lg.down{animation:down 0.8s ease}div.datedropper .picker .pick-lg .pick-h:after,div.datedropper .picker .pick-lg .pick-h:before{opacity:0.32}div.datedropper .picker .pick-lg ul:after{content:"";display:table;clear:both}div.datedropper .picker .pick-lg ul li{float:left;text-align:center;width:14.285714286%;display:flex;align-items:center;justify-content:center;text-align:center;font-size:14px;position:relative}div.datedropper .picker .pick-lg ul li:after,div.datedropper .picker .pick-lg ul li:before{position:absolute;z-index:2;display:block;line-height:30px;height:30px;width:30px;top:50%;left:50%;transform:translate(-50%,-50%)}div.datedropper .picker .pick-lg ul li:after{content:attr(data-value);z-index:2}div.datedropper .picker .pick-lg ul li:before{content:""}div.datedropper .picker .pick-lg ul.pick-lg-h{height:16.6666666667%;padding:0 10px}div.datedropper .picker .pick-lg ul.pick-lg-h li{height:100%}div.datedropper .picker .pick-lg ul.pick-lg-b{height:83.3333333333%;padding:10px}div.datedropper .picker .pick-lg ul.pick-lg-b li{height:16.6666666667%;cursor:pointer;position:relative}div.datedropper .picker .pick-lg ul.pick-lg-b li div{position:absolute;top:0;left:0;right:0;bottom:0;z-index:1}div.datedropper .picker .pick-lg ul.pick-lg-b li.pick-lk{pointer-events:none;opacity:0.6}div.datedropper .picker .pick-lg ul.pick-lg-b li.pick-lk:after{text-decoration:line-through}div.datedropper .picker .pick-lg ul.pick-lg-b li.pick-dir div{opacity:0.25}div.datedropper .picker .pick-lg ul.pick-lg-b li:not(.pick-h):hover{z-index:2}div.datedropper .picker .pick-lg ul.pick-lg-b li:not(.pick-h):hover:before{border-radius:32px;box-shadow:0 0 32px rgba(0,0,0,0.1)}div.datedropper .picker .pick-lg ul.pick-lg-b li:not(.pick-h):hover:after,div.datedropper .picker .pick-lg ul.pick-lg-b li:not(.pick-h):hover:before{transform:translate(-50%,-50%) scale(1.5)}div.datedropper .picker .pick-lg ul.pick-lg-b li.pick-today:not(:hover):not(.pick-sl):before{z-index:2;border-radius:32px;opacity:0.15}div.datedropper .picker .pick-lg ul.pick-lg-b li.pick-sl:before{z-index:2;border-radius:32px;box-shadow:0 0 32px rgba(0,0,0,0.1)}div.datedropper .picker .pick-lg ul.pick-lg-b li.pick-sl:after,div.datedropper .picker .pick-lg ul.pick-lg-b li.pick-sl:before{transform:translate(-50%,-50%) scale(1.5)}div.datedropper .picker .pick-lg ul.pick-lg-b li.pick-sl.pick-sl-a:not(.pick-sl-b):before{border-top-right-radius:8px;transform:translate(-50%,-50%) scale(1.5) rotate(45deg)!important}div.datedropper .picker .pick-lg ul.pick-lg-b li.pick-sl.pick-sl-b:not(.pick-sl-a):before{border-top-left-radius:8px;transform:translate(-50%,-50%) scale(1.5) rotate(-45deg)!important}div.datedropper .picker .pick-btns{margin:-1px;position:relative;z-index:11;height:56px}div.datedropper .picker .pick-btns div{cursor:pointer;line-height:0}div.datedropper .picker .pick-btns .pick-btn{position:absolute;width:36px;height:36px;bottom:0;text-align:center;line-height:38px;font-size:16px;margin:8px;outline:0;border-radius:4px;background:rgba(0,0,0,0.03);box-shadow:0 0 32px rgba(0,0,0,0.1);transform:scale(1)}div.datedropper .picker .pick-btns .pick-btn svg{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%)}div.datedropper .picker .pick-btns .pick-btn:focus,div.datedropper .picker .pick-btns .pick-btn:hover{box-shadow:0 0 24px rgba(0,0,0,0.1);transform:scale(0.95)}div.datedropper .picker .pick-btns .pick-btn.pick-btn-sz{right:0}div.datedropper .picker .pick-btns .pick-btn.pick-btn-lng{left:0;transform-origin:left bottom}div.datedropper.picker-clean .picker-jumped-years{display:none}div.datedropper .picker-jumped-years{position:absolute;z-index:10;top:60px;left:0;right:0;bottom:0;padding:4px;padding-bottom:56px;opacity:0;overflow:hidden;overflow-y:scroll;-webkit-overflow-scrolling:touch;visibility:hidden;pointer-events:none;transform:translateY(16px);transform-origin:bottom center}div.datedropper .picker-jumped-years.picker-jumper-years-visible{opacity:1;visibility:visible;transform:translateY(0);pointer-events:auto}div.datedropper .picker-jumped-years>div{float:left;width:50%;padding:4px;position:relative;cursor:pointer}div.datedropper .picker-jumped-years>div:before{content:"";display:block;border-radius:6px;padding:16px;padding-bottom:50%;background-color:rgba(0,0,0,0.05)}div.datedropper .picker-jumped-years>div:after{text-align:center;font-size:20px;content:attr(data-id);position:absolute;top:50%;left:50%;transform:translate(-50%,-50%)}div.datedropper .picker-jumped-years>div:hover:before{background-color:rgba(0,0,0,0.025)}div.datedropper.picker-lg{width:300px}div.datedropper.picker-lg ul.pick.pick-d{transform:scale(0);height:0!important}div.datedropper.picker-lg .pick-lg{height:256px}@media only screen and (max-width:479px){div.datedropper.picker-lg{width:auto!important;height:auto!important;top:1rem!important;left:1rem!important;right:1rem!important;bottom:1rem!important;transform:none}div.datedropper.picker-lg.picker-modal{width:100%!important;height:100%!important;padding:1rem!important}div.datedropper.picker-lg .picker{height:100%}div.datedropper.picker-lg .picker .pick{max-height:unset!important}div.datedropper.picker-lg .pick-lg{height:62%!important;max-height:unset!important}div.datedropper.picker-lg .pick-lg .pick-lg-h{height:16.6666666667%}div.datedropper.picker-lg .pick-lg .pick-lg-b{height:83.3333333333%}div.datedropper.picker-lg .pick-lg .pick-lg-b li{height:16.6666666667%}div.datedropper.picker-lg .picker-jumped-years{top:13%!important;padding-bottom:12%!important}div.datedropper.picker-lg .pick-l,div.datedropper.picker-lg .pick-m,div.datedropper.picker-lg .pick-y{height:13%!important}div.datedropper.picker-lg .pick-btns{height:12%!important}}@keyframes picker_rumble{0%,to{transform:translate3d(0,0,0)}10%,30%,50%,70%,90%{transform:translate3d(-2px,0,0)}20%,40%,60%,80%{transform:translate3d(2px,0,0)}}div.datedropper .picker-rumble{animation:picker_rumble 0.4s ease}div.datedropper.picker-locked .pick-submit{opacity:0.35}div.datedropper.picker-locked .pick-submit:hover{box-shadow:none!important}div.datedropper.picker-modal{top:50%!important;left:50%!important;transform:translate3d(-50%,-50%,0)!important;position:fixed!important;margin:0!important}div.datedropper.picker-modal:before{display:none}div.datedropper.picker-fxs{transition:opacity 0.2s ease,visibility 0.2s ease,margin 0.2s ease}@media only screen and (min-width:480px){div.datedropper.picker-fxs.picker-transit{transition:width 0.8s cubic-bezier(1,-0.55,0.2,1.37),opacity 0.2s ease,visibility 0.2s ease,margin 0.2s ease}div.datedropper.picker-fxs.picker-transit .pick-lg{transition:height 0.8s cubic-bezier(1,-0.55,0.2,1.37)}div.datedropper.picker-fxs.picker-transit .pick-d{transition:top 0.8s cubic-bezier(1,-0.55,0.2,1.37),transform 0.8s cubic-bezier(1,-0.55,0.2,1.37),height 0.8s cubic-bezier(1,-0.55,0.2,1.37),background-color 0.4s ease}}div.datedropper.picker-fxs ul.pick.pick-y{transition:background-color 0.4s ease}div.datedropper.picker-fxs ul.pick li{transition:transform 0.4s ease,opacity 0.4s ease}div.datedropper.picker-fxs ul.pick .pick-arw{transition:transform 0.2s ease,opacity 0.2s ease}div.datedropper.picker-fxs ul.pick .pick-arw i{transition:right 0.2s ease,left 0.2s ease}div.datedropper.picker-fxs .picker-jumped-years{transition:transform 0.2s ease,opacity 0.2s ease,visibility 0.2s ease}div.datedropper.picker-fxs .pick-lg .pick-lg-b li{transition:background-color 0.2s ease}div.datedropper.picker-fxs .pick-btns .pick-submit{transition:top 0.2s ease,box-shadow 0.4s ease,background-color 0.4s ease}div.datedropper.picker-fxs .pick-btns .pick-submit svg{height:18px}div.datedropper.picker-fxs .pick-btns .pick-btn{transition:all 0.2s ease}div.datedropper.picker-fxs .pick-btns .pick-btn svg{width:18px;height:18px}div.datedropper .null{transition:none}div.datedropper:not(.picker-lg){width:180px!important;width:var(--dd-width)!important}div.datedropper .picker{box-shadow:0 0 32px 0 rgba(0,0,0,0.1)!important;box-shadow:var(--dd-shadow)!important}div.datedropper .pick:focus:after,div.datedropper .pick:hover:after,div.datedropper .picker{border-radius:6px!important;border-radius:var(--dd-radius)!important}div.datedropper .picker-jumped-years{border-bottom-left-radius:6px!important;border-bottom-right-radius:var(--dd-radius)!important}div.datedropper .pick-dir div,div.datedropper .pick-lg-b .pick-sl:before,div.datedropper .pick-lg-h,div.datedropper .pick-submit,div.datedropper .pick-today:before,div.datedropper:not(.picker-clean) .pick:first-of-type,div.datedropper:not(.picker-clean):before{background-color:#fd4741!important;background-color:var(--dd-color1)!important}div.datedropper .pick-btn,div.datedropper .pick-lg-b .pick-wke,div.datedropper .pick-lg-b li:not(.pick-sl):not(.pick-h):hover:after,div.datedropper .pick-today:after,div.datedropper .pick-y.pick-jump,div.datedropper .picker+div,div.datedropper .pick li span{color:#fd4741!important;color:var(--dd-color1)!important}div.datedropper .pick-btn,div.datedropper .pick-btn:hover,div.datedropper .pick-l,div.datedropper .pick-lg-b li:not(.pick-sl):not(.pick-h):hover:before,div.datedropper .picker,div.datedropper .picker-jumped-years,div.datedropper:before{background-color:white!important;background-color:var(--dd-color2)!important}div.datedropper .pick-arw,div.datedropper .pick-l,div.datedropper .picker{color:#4D4D4D!important;color:var(--dd-color3)!important}div.datedropper .pick-lg-b .pick-sl:after,div.datedropper .pick-lg-h,div.datedropper .pick-submit,div.datedropper:not(.picker-clean) .pick:first-of-type,div.datedropper:not(.picker-clean) .pick:first-of-type *{color:white!important;color:var(--dd-color4)!important}',
}),
    (function (e) {
        var n = {},
            a = null,
            r = null,
            o = null,
            s = null,
            l = null,
            d = {
                init: function (t) {
                    return (
                        e(this).each(function () {
                            t && t.roundtrip && !e(this).attr("data-dd-roundtrip") && e(this).attr("data-dd-roundtrip", t.roundtrip);
                        }),
                        e(this).each(function () {
                            if (!e(this).hasClass("picker-trigger")) {
                                var i = e(this),
                                    a = "datedropper-" + Object.keys(n).length;
                                i.attr("data-datedropper-id", a).addClass("picker-trigger");
                                var r = {
                                    identifier: a,
                                    selector: i,
                                    jump: 10,
                                    maxYear: !1,
                                    minYear: !1,
                                    format: "m/d/Y",
                                    lang: "en",
                                    lock: !1,
                                    theme: "primary",
                                    disabledDays: !1,
                                    large: !1,
                                    largeDefault: !1,
                                    fx: !0,
                                    fxMobile: !0,
                                    defaultDate: null,
                                    modal: !1,
                                    hideDay: !1,
                                    hideMonth: !1,
                                    hideYear: !1,
                                    enabledDays: !1,
                                    largeOnly: !1,
                                    roundtrip: !1,
                                    minRoundtripSelection: !1,
                                    eventListener: i.is("input") ? "focus" : "click",
                                    trigger: !1,
                                    minDate: !1,
                                    maxDate: !1,
                                    autofill: !0,
                                    autoIncrease: !0,
                                    showOnlyEnabledDays: !1,
                                    changeValueTo: !1,
                                    startFromMonday: !0,
                                    loopAll: !0,
                                    loopYears: !0,
                                    loopDays: !0,
                                    loopMonths: !0,
                                };
                                (n[a] = e.extend(!0, {}, r, t, v(i))), $(n[a]);
                            }
                        })
                    );
                },
                show: function () {
                    return e(this).each(function () {
                        H(e(this));
                    });
                },
                hide: function () {
                    return e(this).each(function (t) {
                        var n = M(e(this));
                        n && U(n);
                    });
                },
                destroy: function (t) {
                    return e(this).each(function () {
                        var n = M(e(this));
                        n && (a && n.identifier == a.identifier && U(a), e(this).removeAttr("data-datedropper-id").removeClass("picker-trigger").off(n.eventListener), delete n, t && t());
                    });
                },
                set: function (t) {
                    return e(this).each(function () {
                        var n = M(e(this));
                        n &&
                            (e.each(t, function (e, t) {
                                "true" == t && (t = !0), "false" == t && (t = !1), "roundtrip" != e ? (n[e] = t) : console.error("[DATEDROPPER] You can't set roundtrip after main initialization");
                            }),
                            n.selector.off(n.eventListener),
                            n.trigger && e(n.trigger).off("click"),
                            $(n),
                            a && a.element == n.element && q(n));
                    });
                },
                setDate: function (t) {
                    return e(this).each(function () {
                        var n = M(e(this));
                        n &&
                            (e.each(t, function (e, t) {
                                "y" == e && n.key[e] && t > n.key[e].max && (n.key[e].max = t), (n.key[e].current = t);
                            }),
                            a && a.element == n.element && q(n));
                    });
                },
                getDate: function (t) {
                    return e(this).each(function () {
                        var n = M(e(this));
                        n && t && t(O(n));
                    });
                },
            },
            u = !1,
            p = function () {
                var e = navigator.userAgent.toLowerCase();
                return -1 != e.indexOf("msie") && parseInt(e.split("msie")[1]);
            },
            f = function () {
                return !!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            },
            g = function (t) {
                t.fx && !t.fxMobile && (e(window).width() < 480 ? t.element.removeClass("picker-fxs") : t.element.addClass("picker-fxs"));
            },
            h = function (e) {
                return e % 1 == 0 && e;
            },
            m = function (e) {
                return !!/(^\d{1,4}[\.|\\/|-]\d{1,2}[\.|\\/|-]\d{1,4})(\s*(?:0?[1-9]:[0-5]|1(?=[012])\d:[0-5])\d\s*[ap]m)?$/.test(e) && e;
            };
        if (f()) var b = { i: "touchstart", m: "touchmove", e: "touchend" };
        else b = { i: "mousedown", m: "mousemove", e: "mouseup" };
        var v = function (t) {
                var n = {},
                    i = /^data-dd\-(.+)$/;
                return (
                    e.each(t.get(0).attributes, function (e, t) {
                        if (i.test(t.nodeName)) {
                            var a = ((o = t.nodeName.match(i)[1]),
                                o
                                    .replace(/(?:^\w|[A-Z]|\b\w)/g, function (e, t) {
                                        return 0 == t ? e.toLowerCase() : e.toUpperCase();
                                    })
                                    .replace(/\s+/g, "")).replace(new RegExp("-", "g"), ""),
                                r = !1;
                            switch (t.nodeValue) {
                                case "true":
                                    r = !0;
                                    break;
                                case "false":
                                    r = !1;
                                    break;
                                default:
                                    r = t.nodeValue;
                            }
                            n[a] = r;
                        }
                        var o;
                    }),
                    n
                );
            },
            y = function (e) {
                return new Date(1e3 * e);
            },
            _ = function (e, t) {
                return Math.round((y(t) - y(e)) / 864e5) + 1;
            },
            w = function (n, i) {
                var a,
                    r = z(n),
                    o = !1,
                    s = !1,
                    l = !1,
                    d = !0;
                if (
                    (r &&
                        e.each(r, function (e, t) {
                            var i = B(t.value);
                            i.m == k(n, "m") && i.y == k(n, "y") && N(n, ".pick-lg-b li.pick-v[data-value=" + i.d + "]").addClass("pick-sl pick-sl-" + e);
                        }),
                    (o = N(n, ".pick-lg-b li.pick-sl-a")),
                    (s = i || N(n, ".pick-lg-b li.pick-sl-b")),
                    (a = { a: o.length ? N(n, ".pick-lg-b li").index(o) + 1 : 0, b: s.length ? N(n, ".pick-lg-b li").index(s) - 1 : N(n, ".pick-lg-b li").last().index() }),
                    r.a.value != r.b.value && i && (d = !1),
                    i ? ((t = I(k(n, "m") + "/" + i.attr("data-value") + "/" + k(n, "y"))), r.a.value == r.b.value && t > r.a.value && (l = !0)) : ((t = I(k(n))), ((t >= r.a.value && t <= r.b.value) || o.length) && (l = !0)),
                    d && N(n, ".pick-lg-b li").removeClass("pick-dir pick-dir-sl pick-dir-first pick-dir-last"),
                    l)
                )
                    for (var c = a.a; c <= a.b; c++) N(n, ".pick-lg-b li").eq(c).addClass("pick-dir");
                o.next(".pick-dir").addClass("pick-dir-first"), s.prev(".pick-dir").addClass("pick-dir-last");
            },
            k = function (e, t) {
                return t ? parseInt(e.key[t].current) : k(e, "m") + "/" + k(e, "d") + "/" + k(e, "y");
            },
            x = function (e, t) {
                return t ? parseInt(e.key[t].today) : x(e, "m") + "/" + x(e, "d") + "/" + x(e, "y");
            },
            E = function (e, t, n) {
                var i = e.key[t];
                return n > i.max ? E(e, t, n - i.max + (i.min - 1)) : n < i.min ? E(e, t, n + 1 + (i.max - i.min)) : n;
            },
            C = function (e) {
                return !!e && { selector: e.selector, date: O(e) };
            },
            A = function (e, t) {
                return N(e, 'ul.pick[data-k="' + t + '"]');
            },
            S = function (t, n, i) {
                ul = A(t, n);
                var a = [];
                return (
                    ul.find("li").each(function () {
                        a.push(e(this).attr("value"));
                    }),
                    "last" == i ? a[a.length - 1] : a[0]
                );
            },
            T = function (t, n) {
                var i = !1;
                for (var r in (("Y" != t.format && "m" != t.format) || ((t.hideDay = !0), "Y" == t.format && (t.hideMonth = !0), "m" == t.format && (t.hideYear = !0), (i = !0)),
                (t.hideDay || t.hideMonth || t.hideYear) && (i = !0),
                t.largeOnly && ((t.large = !0), (t.largeDefault = !0)),
                (t.hideMonth || t.hideDay || t.hideYear || t.showOnlyEnabledDays) && ((t.largeOnly = !1), (t.large = !1), (t.largeDefault = !1)),
                (t.element = e("<div>", {
                    class: "datedropper " + (i ? "picker-clean" : "") + " " + (t.modal ? "picker-modal" : "") + " " + t.theme + " " + (t.fx ? "picker-fxs" : "") + " " + (t.large && t.largeDefault ? "picker-lg" : ""),
                    id: t.identifier,
                    html: e("<div>", { class: "picker" }),
                }).appendTo("body")),
                t.key)) {
                    var o = !0;
                    "y" == r && t.hideYear && (o = !1), "d" == r && t.hideDay && (o = !1), "m" == r && t.hideMonth && (o = !1), o && (e("<ul>", { class: "pick pick-" + r, "data-k": r, tabindex: 0 }).appendTo(N(t, ".picker")), K(t, r));
                }
                t.large && e("<div>", { class: "pick-lg" }).insertBefore(N(t, ".pick-d")),
                    e("<div>", { class: "pick-btns" }).appendTo(N(t, ".picker")),
                    e("<div>", { tabindex: 0, class: "pick-submit", html: e(e.dateDropperSetup.icons.checkmark) }).appendTo(N(t, ".pick-btns")),
                    t.large && !t.largeOnly && e("<div>", { class: "pick-btn pick-btn-sz", html: e(e.dateDropperSetup.icons.expand) }).appendTo(N(t, ".pick-btns")),
                    setTimeout(function () {
                        t.element.addClass("picker-focused"),
                            f() ||
                                setTimeout(function () {
                                    N(t, ".pick:first-of-type").focus();
                                }, 100),
                            t.element.hasClass("picker-modal") && (t.overlay = e('<div class="picker-overlay"></div>').appendTo("body")),
                            g(t),
                            P(t),
                            V(t),
                            (a = t),
                            n && n();
                    }, 100);
            },
            M = function (e) {
                var t = e.attr("data-datedropper-id");
                return n[t] || !1;
            },
            N = function (e, t) {
                if (e.element) return e.element.find(t);
            },
            D = function (t, n) {
                if ("string" == typeof n) {
                    if (m(n)) {
                        var i = n.match(/\d+/g);
                        return (
                            e.each(i, function (e, t) {
                                i[e] = parseInt(t);
                            }),
                            { m: i[0] && i[0] <= 12 ? i[0] : t.key.m.today, d: i[1] && i[1] <= 31 ? i[1] : t.key.d.today, y: i[2] || t.key.y.today }
                        );
                    }
                    return !1;
                }
                return !1;
            },
            L = "div.datedropper.picker-focused",
            O = function (t, n) {
                n || (n = { d: k(t, "d"), m: k(t, "m"), y: k(t, "y") });
                var i = n.d,
                    a = n.m,
                    r = n.y,
                    o = new Date(a + "/" + i + "/" + r).getDay(),
                    s = {
                        F: e.dateDropperSetup.languages[t.lang].months.full[a - 1],
                        M: e.dateDropperSetup.languages[t.lang].months.short[a - 1],
                        D: e.dateDropperSetup.languages[t.lang].weekdays.full[o].substr(0, 3),
                        l: e.dateDropperSetup.languages[t.lang].weekdays.full[o],
                        d: R(i),
                        m: R(a),
                        S: j(i),
                        Y: r,
                        U: I(k(t)),
                        n: a,
                        j: i,
                    },
                    l = t.format
                        .replace(/\b(F)\b/g, s.F)
                        .replace(/\b(M)\b/g, s.M)
                        .replace(/\b(D)\b/g, s.D)
                        .replace(/\b(l)\b/g, s.l)
                        .replace(/\b(d)\b/g, s.d)
                        .replace(/\b(m)\b/g, s.m)
                        .replace(/\b(S)\b/g, s.S)
                        .replace(/\b(Y)\b/g, s.Y)
                        .replace(/\b(U)\b/g, s.U)
                        .replace(/\b(n)\b/g, s.n)
                        .replace(/\b(j)\b/g, s.j);
                return (s.formatted = l), s;
            },
            R = function (e) {
                return e < 10 ? "0" + e : e;
            },
            j = function (e) {
                var t = ["th", "st", "nd", "rd"],
                    n = e % 100;
                return e + (t[(n - 20) % 10] || t[n] || t[0]);
            },
            I = function (e) {
                return Date.parse(e) / 1e3;
            },
            B = function (e) {
                var t = new Date(1e3 * e);
                return { m: t.getMonth() + 1, y: t.getFullYear(), d: t.getDate() };
            },
            z = function (t) {
                var n = '[data-dd-roundtrip="' + t.roundtrip + '"]',
                    i = !1;
                return (
                    e(n).length &&
                        ((i = {}),
                        e.each(["a", "b"], function (t, a) {
                            var r = e(n + "[data-dd-roundtrip-" + a + "]");
                            i[a] = { value: (r.length && r.attr("data-dd-roundtrip-" + a)) || !1, selector: !!r.length && r };
                        })),
                    i
                );
            },
            F = function (e) {
                e.large &&
                    (e.element.addClass("picker-transit").toggleClass("picker-lg"),
                    e.element.hasClass("picker-lg") && G(e),
                    setTimeout(function () {
                        e.element.removeClass("picker-transit");
                    }, 800));
            },
            P = function (e) {
                if (!e.element.hasClass("picker-modal")) {
                    var t = e.selector,
                        n = t.offset().left + t.outerWidth() / 2,
                        i = t.offset().top + t.outerHeight();
                    e.element.css({ left: n, top: i });
                }
            },
            $ = function (t) {
                (t.jump = h(t.jump) || 10),
                    (t.maxYear = h(t.maxYear)),
                    (t.minYear = h(t.minYear)),
                    t.lang in e.dateDropperSetup.languages || (t.lang = "en"),
                    (t.key = {
                        m: { min: 1, max: 12, current: new Date().getMonth() + 1, today: new Date().getMonth() + 1 },
                        d: { min: 1, max: 31, current: new Date().getDate(), today: new Date().getDate() },
                        y: { min: t.minYear || new Date().getFullYear() - 50, max: t.maxYear || new Date().getFullYear() + 50, current: new Date().getFullYear(), today: new Date().getFullYear() },
                    }),
                    t.key.y.current > t.key.y.max && (t.key.y.current = t.key.y.max),
                    t.key.y.current < t.key.y.min && (t.key.y.current = t.key.y.min),
                    t.minYear && (t.minDate = "01/01/" + t.minYear),
                    t.maxYear && (t.maxDate = "12/31/" + t.maxYear);
                var n = t.defaultDate ? I(t.defaultDate) : I(k(t));
                if (t.minDate) {
                    var i = !!t.minDate && I(t.minDate);
                    n && i & (n < i) && (t.defaultDate = t.minDate);
                }
                if (t.maxDate) {
                    var a = !!t.maxDate && I(t.maxDate);
                    n && a && n > a && (t.defaultDate = t.maxDate);
                }
                if (
                    (t.defaultDate && Y(t, B(I(t.defaultDate))),
                    (t.disabledDays = t.disabledDays ? t.disabledDays.split(",") : null),
                    (t.enabledDays = t.enabledDays ? t.enabledDays.split(",") : null),
                    t.disabledDays &&
                        e.each(t.disabledDays, function (e, n) {
                            n && m(n) && (t.disabledDays[e] = I(n));
                        }),
                    t.enabledDays &&
                        e.each(t.enabledDays, function (e, n) {
                            n && m(n) && (t.enabledDays[e] = I(n));
                        }),
                    t.showOnlyEnabledDays && t.enabledDays)
                ) {
                    var r = (n = !!t.defaultDate && I(t.defaultDate)) && t.enabledDays.includes(n) ? B(n) : B(t.enabledDays[0]);
                    e.each(r, function (e, n) {
                        t.key[e].current = n;
                    });
                } else t.showOnlyEnabledDays = !1;
                if (t.roundtrip) {
                    I(k(t));
                    var o = e('[data-dd-roundtrip="' + t.roundtrip + '"]');
                    o.length > 1
                        ? o.each(function () {
                              var t = 0 == o.index(e(this)) ? "a" : "b";
                              e(this).attr("data-dd-roundtrip-" + t, 0), e(this).attr("data-dd-roundtrip-selector", "b");
                          })
                        : (e.each(["a", "b"], function (e, n) {
                              t.selector.attr("data-dd-roundtrip-" + n, 0);
                          }),
                          t.selector.attr("data-dd-roundtrip-selector", "b"));
                    var s = e('[data-dd-roundtrip="' + t.roundtrip + '"][data-dd-roundtrip-a]'),
                        l = e('[data-dd-roundtrip="' + t.roundtrip + '"][data-dd-roundtrip-b]');
                    if (s.attr("data-dd-default-date") && l.attr("data-dd-default-date")) {
                        var d = I(s.attr("data-dd-default-date")),
                            c = I(l.attr("data-dd-default-date"));
                        d && c && (s.attr("data-dd-roundtrip-a", d), l.attr("data-dd-roundtrip-b", c));
                    }
                    t.largeOnly = !0;
                }
                if (
                    (t.selector.on(t.eventListener, function (t) {
                        t.preventDefault(), e(this).blur(), H(e(this));
                    }),
                    t.trigger &&
                        e(t.trigger).on("click", function (e) {
                            t.selector.trigger(t.eventListener);
                        }),
                    t.onReady && t.onReady(C(t)),
                    t.defaultDate)
                ) {
                    var u = D(t, t.defaultDate);
                    u &&
                        (e.each(u, function (e, n) {
                            t.key[e] && (t.key[e].current = n);
                        }),
                        t.key.y.current > t.key.y.max && (t.key.y.max = t.key.y.current),
                        t.key.y.current < t.key.y.min && (t.key.y.min = t.key.y.current));
                }
            },
            q = function (e, t) {
                e.element && (e.element.remove(), e.overlay && e.overlay.remove(), T(e));
            },
            H = function (e, t) {
                a && U(a);
                var n = M(e);
                n && T(n);
            },
            U = function (e) {
                var t = { element: e.element, overlay: e.overlay };
                t.element &&
                    (t.element.removeClass("picker-focused"),
                    setTimeout(function () {
                        t.element.remove(), t.overlay && t.overlay.addClass("picker-overlay-hidden");
                    }, 400)),
                    (a = null);
            },
            W = function (e) {
                if (e) {
                    var t,
                        n,
                        i = !1;
                    return (
                        (t = I(k(e))),
                        (n = I(x(e))),
                        e.lock && ("from" == e.lock && (i = t < n), "to" == e.lock && (i = t > n)),
                        (e.minDate || e.maxDate) && ((t = I(k(e))), (n = e.minDate ? I(e.minDate) : null), (c = e.maxDate ? I(e.maxDate) : null), n && c ? (i = t < n || t > c) : n ? (i = t < n) : c && (i = t > c)),
                        e.disabledDays && !e.enabledDays && (i = -1 != e.disabledDays.indexOf(t)),
                        e.enabledDays && !e.disabledDays && (i = -1 == e.enabledDays.indexOf(t)),
                        i ? (ee(e), e.element.addClass("picker-locked"), !0) : (e.element.removeClass("picker-locked"), !1)
                    );
                }
            },
            K = function (t, n) {
                var a = A(t, n),
                    r = t.key[n];
                for (a.empty(), i = r.min; i <= r.max; i++) {
                    var o = i;
                    "m" == n && (o = e.dateDropperSetup.languages[t.lang].months.short[i - 1]), (o += "d" == n ? "<span></span>" : ""), e("<li>", { value: i, html: "<div>" + o + "</div>" }).appendTo(a);
                }
                e.each(["l", "r"], function (t, n) {
                    e("<div>", { class: "pick-arw pick-arw-s1 pick-arw-" + n, html: e("<div>", { class: "pick-i-" + n, html: e(e.dateDropperSetup.icons.arrow[n]) }) }).appendTo(a);
                }),
                    "y" == n &&
                        e.each(["l", "r"], function (t, n) {
                            e("<div>", { class: "pick-arw pick-arw-s2 pick-arw-" + n, html: e("<div>", { class: "pick-i-" + n, html: e(e.dateDropperSetup.icons.arrow[n]) }) }).appendTo(a);
                        }),
                    Z(t, n, k(t, n));
            },
            G = function (t) {
                N(t, ".pick-lg").empty().append('<ul class="pick-lg-h"></ul><ul class="pick-lg-b"></ul>');
                for (
                    var n = (function (e) {
                            return e.startFromMonday ? [1, 2, 3, 4, 5, 6, 0] : [0, 1, 2, 3, 4, 5, 6];
                        })(t),
                        i = 0;
                    i < 7;
                    i++
                )
                    e("<li>", { html: "<div>" + e.dateDropperSetup.languages[t.lang].weekdays.short[n[i]] + "</div>" }).appendTo(N(t, ".pick-lg .pick-lg-h"));
                for (i = 0; i < 42; i++) e("<li>", { html: e("<div>") }).appendTo(N(t, ".pick-lg .pick-lg-b"));
                var a = 0,
                    r = N(t, ".pick-lg-b"),
                    o = (new Date(k(t)), new Date(k(t))),
                    s = new Date(k(t)),
                    l = function (e) {
                        var t = e.getMonth(),
                            n = e.getFullYear();
                        return [31, n % 4 != 0 || (n % 100 == 0 && n % 400 != 0) ? 28 : 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][t];
                    };
                s.setMonth(s.getMonth() - 1), o.setDate(1);
                var d = o.getDay() - 1;
                for (d < 0 && (d = 6), t.startFromMonday && --d < 0 && (d = 6), i = l(s) - d; i <= l(s); i++) r.find("li").eq(a).addClass("pick-b pick-n pick-h").attr("data-value", i), a++;
                for (i = 1; i <= l(o); i++) r.find("li").eq(a).addClass("pick-n pick-v").attr("data-value", i), a++;
                if (r.find("li.pick-n").length < 42) {
                    var c = 42 - r.find("li.pick-n").length;
                    for (i = 1; i <= c; i++) r.find("li").eq(a).addClass("pick-a pick-n pick-h").attr("data-value", i), a++;
                }
                if (
                    (t.lock &&
                        ("from" === t.lock
                            ? k(t, "y") <= x(t, "y") &&
                              (k(t, "m") == x(t, "m")
                                  ? N(t, '.pick-lg .pick-lg-b li.pick-v[data-value="' + x(t, "d") + '"]')
                                        .prevAll("li")
                                        .addClass("pick-lk")
                                  : (k(t, "m") < x(t, "m") || (k(t, "m") > x(t, "m") && k(t, "y") < x(t, "y"))) && N(t, ".pick-lg .pick-lg-b li").addClass("pick-lk"))
                            : k(t, "y") >= x(t, "y") &&
                              (k(t, "m") == x(t, "m")
                                  ? N(t, '.pick-lg .pick-lg-b li.pick-v[data-value="' + x(t, "d") + '"]')
                                        .nextAll("li")
                                        .addClass("pick-lk")
                                  : (k(t, "m") > x(t, "m") || (k(t, "m") < x(t, "m") && k(t, "y") > x(t, "y"))) && N(t, ".pick-lg .pick-lg-b li").addClass("pick-lk"))),
                    t.maxDate)
                ) {
                    var u = D(t, t.maxDate);
                    if (u)
                        if (k(t, "y") == u.y && k(t, "m") == u.m)
                            N(t, '.pick-lg .pick-lg-b li.pick-v[data-value="' + u.d + '"]')
                                .nextAll("li")
                                .addClass("pick-lk");
                        else {
                            var p = I(t.maxDate);
                            I(k(t)) > p && N(t, ".pick-lg .pick-lg-b li.pick-v").addClass("pick-lk");
                        }
                }
                if (t.minDate) {
                    var f = D(t, t.minDate);
                    if (f)
                        if (k(t, "y") == f.y && k(t, "m") == f.m)
                            N(t, '.pick-lg .pick-lg-b li.pick-v[data-value="' + f.d + '"]')
                                .prevAll("li")
                                .addClass("pick-lk");
                        else {
                            var g = I(t.minDate);
                            I(k(t)) < g && N(t, ".pick-lg .pick-lg-b li.pick-v").addClass("pick-lk");
                        }
                }
                t.disabledDays &&
                    !t.enabledDays &&
                    e.each(t.disabledDays, function (e, n) {
                        if (n) {
                            var i = B(n);
                            i.m == k(t, "m") && i.y == k(t, "y") && N(t, '.pick-lg .pick-lg-b li.pick-v[data-value="' + i.d + '"]').addClass("pick-lk");
                        }
                    }),
                    t.enabledDays &&
                        !t.disabledDays &&
                        (N(t, ".pick-lg .pick-lg-b li").addClass("pick-lk"),
                        e.each(t.enabledDays, function (e, n) {
                            if (n) {
                                var i = B(n);
                                i.m == k(t, "m") && i.y == k(t, "y") && N(t, '.pick-lg .pick-lg-b li.pick-v[data-value="' + i.d + '"]').removeClass("pick-lk");
                            }
                        })),
                    t.roundtrip ? w(t) : N(t, ".pick-lg-b li.pick-v[data-value=" + k(t, "d") + "]").addClass("pick-sl"),
                    k(t, "m") == x(t, "m") && k(t, "y") == x(t, "y") && N(t, ".pick-lg-b li.pick-v[data-value=" + x(t, "d") + "]").addClass("pick-today");
            },
            Y = function (t, n) {
                e.each(n, function (e, n) {
                    t.key[e].current = n;
                });
            },
            V = function (t, n) {
                t.element.hasClass("picker-lg") && G(t),
                    (function (t) {
                        var n = k(t, "m"),
                            i = k(t, "y"),
                            a = i % 4 == 0 && (i % 100 != 0 || i % 400 == 0);
                        (t.key.d.max = [31, a ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][n - 1]),
                            k(t, "d") > t.key.d.max && ((t.key.d.current = t.key.d.max), Z(t, "d", k(t, "d"))),
                            N(t, ".pick-d li")
                                .removeClass("pick-wke")
                                .each(function () {
                                    var a = new Date(n + "/" + e(this).attr("value") + "/" + i).getDay();
                                    e(this).find("span").html(e.dateDropperSetup.languages[t.lang].weekdays.full[a]), (0 != a && 6 != a) || e(this).addClass("pick-wke");
                                }),
                            t.element.hasClass("picker-lg") &&
                                (N(t, ".pick-lg-b li").removeClass("pick-wke"),
                                N(t, ".pick-lg-b li.pick-v").each(function () {
                                    var t = new Date(n + "/" + e(this).attr("data-value") + "/" + i).getDay();
                                    (0 != t && 6 != t) || e(this).addClass("pick-wke");
                                }));
                    })(t),
                    W(t) ||
                        ((function (e) {
                            clearInterval(s);
                            var t = e.minYear || e.key.y.current - 50,
                                n = e.maxYear || e.key.y.current + 50;
                            (e.key.y.max = n),
                                (e.key.y.min = t),
                                (s = setTimeout(function () {
                                    K(e, "y");
                                }, 400));
                        })(t),
                        te(t),
                        n && n(t));
            },
            Z = function (e, t, n) {
                var i,
                    a = A(e, t);
                a.find("li").removeClass("pick-sl pick-bfr pick-afr"),
                    n == S(e, t, "last") && ((i = a.find('li[value="' + S(e, t, "first") + '"]')).clone().insertAfter(a.find("li[value=" + n + "]")), i.remove()),
                    n == S(e, t, "first") && ((i = a.find('li[value="' + S(e, t, "last") + '"]')).clone().insertBefore(a.find("li[value=" + n + "]")), i.remove()),
                    a.find("li[value=" + n + "]").addClass("pick-sl"),
                    a.find("li.pick-sl").nextAll("li").addClass("pick-afr"),
                    a.find("li.pick-sl").prevAll("li").addClass("pick-bfr"),
                    X(e);
            },
            X = function (e) {
                (e.loopAll && e.loopYears) ||
                    (e.minYear && e.key.y.current == e.minYear ? N(e, ".pick-y .pick-arw-l").addClass("pick-arw-hidden") : N(e, ".pick-y .pick-arw-l").removeClass("pick-arw-hidden"),
                    e.maxYear && e.key.y.current == e.maxYear ? N(e, ".pick-y .pick-arw-r").addClass("pick-arw-hidden") : N(e, ".pick-y .pick-arw-r").removeClass("pick-arw-hidden")),
                    (e.loopAll && e.loopMonths) ||
                        (e.key.m.current == e.key.m.min ? N(e, ".pick-m .pick-arw-l").addClass("pick-arw-hidden") : N(e, ".pick-m .pick-arw-l").removeClass("pick-arw-hidden"),
                        e.key.m.current == e.key.m.max ? N(e, ".pick-m .pick-arw-r").addClass("pick-arw-hidden") : N(e, ".pick-m .pick-arw-r").removeClass("pick-arw-hidden")),
                    (e.loopAll && e.loopDays) ||
                        (e.key.d.current == e.key.d.min ? N(e, ".pick-d .pick-arw-l").addClass("pick-arw-hidden") : N(e, ".pick-d .pick-arw-l").removeClass("pick-arw-hidden"),
                        e.key.d.current == e.key.d.max ? N(e, ".pick-d .pick-arw-r").addClass("pick-arw-hidden") : N(e, ".pick-d .pick-arw-r").removeClass("pick-arw-hidden"));
            },
            J = function (e, t, n) {
                var i = e.key[t];
                n > i.max && ("d" == t && e.autoIncrease && Q(e, "m", "right"), "m" == t && e.autoIncrease && Q(e, "y", "right"), (n = i.min)),
                    n < i.min && ("d" == t && e.autoIncrease && Q(e, "m", "left"), "m" == t && e.autoIncrease && Q(e, "y", "left"), (n = i.max)),
                    (e.key[t].current = n),
                    Z(e, t, n);
            },
            Q = function (t, n, i) {
                if (t.showOnlyEnabledDays && t.enabledDays)
                    !(function (t, n) {
                        for (var i = I(k(t)), a = t.enabledDays, r = (a.length, null), o = 0; o < a.length; o++) a[o] === i && (r = o);
                        "right" == n ? r++ : r--;
                        var s = !!a[r] && B(a[r]);
                        s &&
                            e.each(s, function (e, n) {
                                (t.key[e].current = n), J(t, e, n);
                            });
                    })(t, i);
                else {
                    var a = k(t, n);
                    "right" == i ? a++ : a--, J(t, n, a);
                }
            },
            ee = function (e) {
                e.element.find(".picker").addClass("picker-rumble");
            },
            te = function (t, i) {
                var a = !0;
                if (t.roundtrip) {
                    a = !1;
                    var r = z(t);
                    if ("0" != r.a.value && "0" != r.b.value) {
                        var o = _(r.a.value, r.b.value),
                            s = t.minRoundtripSelection;
                        if (s && o <= s) {
                            var l = 86400 * s;
                            r.b.value = parseInt(r.a.value) + l;
                        }
                        var d = t.maxRoundtripSelection;
                        if ((d && o >= d && ((l = 86400 * d), (r.b.value = parseInt(r.a.value) + l)), e('.picker-trigger[data-dd-roundtrip="' + t.selector.data("dd-roundtrip") + '"]').length > 1))
                            e.each(r, function (e, i) {
                                var a = i.selector.attr("data-datedropper-id"),
                                    r = B(i.value),
                                    o = O(t, r);
                                t.identifier != a && n[a] && ((n[a].key.m.current = r.m), (n[a].key.d.current = r.d), (n[a].key.y.current = r.y)), i.selector.is("input") && i.selector.val(o.formatted).change();
                            });
                        else {
                            var c = { a: O(t, B(r.a.value)), b: O(t, B(r.b.value)) };
                            t.selector.val(c.a.formatted + " - " + c.b.formatted);
                        }
                        t.onRoundTripChange && t.onRoundTripChange({ outward: B(r.a.value), return: B(r.b.value), days: _(r.a.value, r.b.value) }), t.onChange && t.onChange(C(t));
                    }
                } else a = !!i || t.autofill;
                if (a) {
                    var u = O(t);
                    t.selector.is("input") && t.selector.val(u.formatted).change(), t.changeValueTo && ne(t, u.formatted), t.onChange && t.onChange(C(t));
                }
            },
            ne = function (t, n) {
                var i = e(t.changeValueTo);
                i.length && i.is("input") && i.val(n).change();
            };
        e(document)
            .on("keydown", function (t) {
                var n = t.which;
                if (a && !f())
                    if (32 == n) N(a, ":focus").click(), t.preventDefault();
                    else if (9 == n && t.shiftKey) e(t.target).is(".pick-m") && (t.preventDefault(), e(".datedropper .pick-submit").focus());
                    else if (9 == n) e(t.target).is(".pick-submit") && (t.preventDefault(), e(".datedropper .pick-m").focus());
                    else if (27 == n) U(a);
                    else if (13 == n) N(a, ".pick-submit").trigger(b.i);
                    else if (37 == n || 39 == n) {
                        var i = N(a, ".pick:focus");
                        if (i.length && (37 == n || 39 == n)) {
                            if (37 == n) var r = "left";
                            39 == n && (r = "right");
                            var o = i.attr("data-k");
                            Q(a, o, r), V(a);
                        }
                    }
            })
            .on("focus", ".pick-d", function () {
                if (a) {
                    var e = a.element.find(".pick-lg");
                    e.length && !e.hasClass("pick-lg-focused") && e.addClass("pick-lg-focused");
                }
            })
            .on("blur", ".pick-d", function () {
                if (a) {
                    var e = a.element.find(".pick-lg");
                    e.length && e.hasClass("pick-lg-focused") && e.removeClass("pick-lg-focused");
                }
            })
            .on("click", function (e) {
                a && (a.selector.is(e.target) || a.element.is(e.target) || 0 !== a.element.has(e.target).length || (U(a), (r = null)));
            })
            .on("webkitAnimationEnd mozAnimationEnd oAnimationEnd oanimationend animationend", L + " .picker-rumble", function () {
                e(this).removeClass("picker-rumble");
            })
            .on("transitionend webkitTransitionEnd oTransitionEnd otransitionend MSTransitionEnd", ".picker-overlay", function () {
                e(this).remove();
            })
            .on(b.i, L + " .pick-lg li.pick-v", function () {
                if (a) {
                    if ((N(a, ".pick-lg-b li").removeClass("pick-sl"), e(this).addClass("pick-sl"), (a.key.d.current = e(this).attr("data-value")), Z(a, "d", e(this).attr("data-value")), a.roundtrip)) {
                        var t = z(a),
                            n = I(k(a));
                        if (t) {
                            var i = t.a.value == t.b.value ? "b" : "a";
                            "b" == i && (n <= t.a.value || "0" == t.a.value) && (i = "a"),
                                "a" == i
                                    ? e.each(t, function (e) {
                                          t[e].selector.attr("data-dd-roundtrip-" + e, n).attr("data-dd-roundtrip-selector", i);
                                      })
                                    : t[i].selector.attr("data-dd-roundtrip-" + i, n).attr("data-dd-roundtrip-selector", i);
                        }
                    }
                    V(a);
                }
            })
            .on("mouseleave", L + " .pick-lg .pick-lg-b li", function () {
                a && a.roundtrip && w(a);
            })
            .on("mouseenter", L + " .pick-lg .pick-lg-b li", function () {
                if (a) {
                    var t = z(a);
                    a.roundtrip && "0" != t.a.value && w(a, e(this));
                }
            })
            .on("click", L + " .pick-btn-sz", function () {
                a && F(a);
            })
            .on(b.i, L + " .pick-arw.pick-arw-s2", function (t) {
                if (a) {
                    var n;
                    t.preventDefault(), (r = null), e(this).closest("ul").data("k");
                    var i = a.jump;
                    n = e(this).hasClass("pick-arw-r") ? k(a, "y") + i : k(a, "y") - i;
                    var o = (function (e, t, n) {
                        for (var i = [], a = e.key.y, r = a.min; r <= a.max; r++) r % n == 0 && i.push(r);
                        return i;
                    })(a, 0, i);
                    n > o[o.length - 1] && (n = o[0]), n < o[0] && (n = o[o.length - 1]), (a.key.y.current = n), Z(a, "y", k(a, "y"));
                }
            })
            .on(b.i, L, function (e) {
                a && N(a, "*:focus").blur();
            })
            .on(b.i, L + " .pick-arw.pick-arw-s1", function (t) {
                if (a) {
                    t.preventDefault(), (r = null);
                    var n = e(this).closest("ul").data("k"),
                        i = e(this).hasClass("pick-arw-r") ? "right" : "left";
                    Q(a, n, i);
                }
            })
            .on(b.i, L + " ul.pick.pick-y li", function () {
                u = !0;
            })
            .on(b.e, L + " ul.pick.pick-y li", function () {
                var t;
                a &&
                    (!u ||
                        (t = a).jump >= t.key.y.max - t.key.y.min ||
                        ((function (t) {
                            var n = N(t, ".picker-jumped-years");
                            n.length && n.remove();
                            var i = e("<div>", { class: "picker-jumped-years" }).appendTo(N(t, ".picker"));
                            setTimeout(function () {
                                i.addClass("picker-jumper-years-visible");
                            }, 100);
                            for (var a = t.key.y.min; a <= t.key.y.max; a++)
                                a % t.jump == 0 &&
                                    e("<div>", { "data-id": a })
                                        .click(function (n) {
                                            var a = e(this).data("id");
                                            J(t, "y", a),
                                                V(t),
                                                i.removeClass("picker-jumper-years-visible"),
                                                setTimeout(function () {
                                                    i.remove();
                                                }, 300);
                                        })
                                        .appendTo(i);
                        })(a),
                        (u = !1)));
            })
            .on(b.i, L + " ul.pick.pick-d li", function () {
                a && (u = !0);
            })
            .on(b.e, L + " ul.pick.pick-d li", function () {
                a && u && (F(a), (u = !1));
            })
            .on(b.i, L + " ul.pick", function (t) {
                if (a && (r = e(this))) {
                    var n = r.data("k");
                    (o = f() ? t.originalEvent.touches[0].pageY : t.pageY), (l = k(a, n));
                }
            })
            .on(b.m, function (e) {
                if (a && ((u = !1), r)) {
                    e.preventDefault();
                    var t = r.data("k"),
                        n = f() ? e.originalEvent.touches[0].pageY : e.pageY;
                    (n = o - n), (n = Math.round(0.026 * n));
                    var i = E(a, t, l + n);
                    i != a.key[t].current && J(a, t, i), a.onPickerDragging && a.onPickerDragging({ key: t, value: i });
                }
            })
            .on(b.e, function (e) {
                r && ((r = null), (o = null), (l = null), a && (V(a), a.onPickerRelease && a.onPickerRelease(O(a))));
            })
            .on(b.i, L + " .pick-submit", function () {
                a && (W(a) || (te(a, !0), U(a)));
            }),
            e(window).resize(function () {
                a && (P(a), g(a));
            }),
            document.addEventListener(
                "touchmove",
                function (t) {
                    var n = e(t.target).closest(".picker-jumped-years").length;
                    a && !n ? (e("html,body").css("touch-action", "none"), t.preventDefault()) : e("html,body").css("touch-action", "unset");
                },
                { passive: !1 }
            ),
            (e.fn.dateDropper = function (e) {
                if (p() && p() < 10) console.error("[DATEDROPPER] This browser is not supported");
                else {
                    if ("object" == typeof e || !e) return d.init.apply(this, arguments);
                    if ("string" == typeof e && d[e]) return d[e].apply(this, Array.prototype.slice.call(arguments, 1));
                    console.error("[DATEDROPPER] This method not exist");
                }
            }),
            e("head").append("<style>" + e.dateDropperSetup.inlineCSS + "</style>"),
            e(document).ready(function () {
                e.dateDropperSetup.autoInit &&
                    e(".datedropper-init, [data-datedropper]").each(function () {
                        e(this).dateDropper();
                    });
            });
    })(jQuery);
var dateDropperSetup = {
    languages: {
        en: {
            m: { s: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"], f: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"] },
            w: { s: ["D", "L", "M", "X", "J", "V", "S"], f: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"] },
        },
    },
};
function inLine() {
    "use strict";
    function e() {
        if (
            ((q.onBlur = function (e) {
                !$.toolbar || $.dropdown || e.target == $.toolbar || $.toolbar.contains(e.target) || a();
            }),
            this.contentWindow.document
                .getElementsByTagName("head")[0]
                .appendChild(
                    j(
                        '@keyframes il_rumble{0%,to{transform:translate3d(0,0,0)}10%,30%,50%,70%,90%{transform:translate3d(-2px,0,0)}20%,40%,60%,80%{transform:translate3d(2px,0,0)}}button,input{border:0;margin:0;padding:0;appearance:none;background:none;outline:0;font-size:100%;color:currentColor}*{box-sizing:border-box;-webkit-tap-highlight-color:transparent;touch-action:manipulation}html{font-family:sans-serif;font-size:15px}input{font-size:16px}:root{--il__panel-backgroundColor:white;--il__panel-color:#252525;--il__button-hover-backgroundColor:rgba(0,0,0,.075);--il__button-open-backgroundColor:rgba(0,0,0,.1);--il__button-active-backgroundColor:#0088FF20;--il__button-active-color:#0088FF;--il__button-active-hover-backgroundColor:#0088FF30;--il__button-active-hover-color:#0088FF;--il__button-cancel-backgroundColor:#ff645c;--il__button-cancel-color:white;--il__button-cancel-hover-backgroundColor:#ff645c30;--il__button-cancel-hover-color:#ff645c;--il__button-confirm-backgroundColor:#6cd26c;--il__button-confirm-color:white;--il__button-confirm-hover-backgroundColor:#6cd26c30;--il__button-confirm-hover-color:#6cd26c;--il__tooltip-backgroundColor:#333;--il__tooltip-color:white;--il__dropdown-backgroundColor:white;--il__dropdown-color:#252525;--il__input-backgroundColor:rgba(0,0,0,0.075);--il__input-color:#252525;--il__button-reset-color:#ff645c}.il--dark{--il__panel-backgroundColor:#333333;--il__panel-color:#F4F4F4;--il__button-hover-backgroundColor:rgba(0,0,0,.15);--il__button-focus-backgroundColor:rgba(255,255,255,.15);--il__button-active-backgroundColor:#111111;--il__button-active-color:#F4F4F4;--il__button-active-hover-backgroundColor:#222222;--il__button-active-hover-color:#F4F4F4;--il__button-cancel-backgroundColor:#222222;--il__button-cancel-color:white;--il__button-cancel-hover-backgroundColor:#111111;--il__button-cancel-hover-color:white;--il__button-confirm-backgroundColor:#222222;--il__button-confirm-color:white;--il__button-confirm-hover-backgroundColor:#111111;--il__button-confirm-hover-color:white;--il__button-open-backgroundColor:rgba(0,0,0,.125);--il__tooltip-backgroundColor:white;--il__tooltip-color:#333;--il__dropdown-backgroundColor:#333333;--il__dropdown-color:#F4F4F4;--il__input-backgroundColor:#222222;--il__input-color:#F4F4F4;--il__button-reset-color:#ff645c}.il--purple{--il__panel-backgroundColor:linear-gradient(120deg,rgba(95,82,255,1) 0%,rgba(200,109,215,1) 100%);--il__panel-color:#F4F4F4;--il__button-hover-backgroundColor:rgba(0,0,0,.15);--il__button-focus-backgroundColor:rgba(255,255,255,.15);--il__button-active-backgroundColor:#F4F4F4;--il__button-active-color:rgba(95,82,255,1);--il__button-active-hover-backgroundColor:rgba(0,0,0,0.2);--il__button-active-hover-color:#F4F4F4;--il__button-open-backgroundColor:rgba(0,0,0,.125)}.il--rumble{animation:il_rumble 0.3s cubic-bezier(0.7,0,0.175,1)}.il__toolbar{position:fixed;opacity:0;visibility:hidden;transform:translateY(1rem) translateX(-50%);transition:opacity 0.6s cubic-bezier(0.165,0.84,0.44,1),visibility 0.6s cubic-bezier(0.165,0.84,0.44,1),transform 0.6s cubic-bezier(0.165,0.84,0.44,1);will-change:transform,opacity,visibility;pointer-events:none}.il__toolbar.il--visible{pointer-events:auto;opacity:1;visibility:visible;transform:translateY(0) translateX(-50%)}@media (max-width:767px){.il__toolbar{top:1rem!important;left:0!important;width:100%!important;transform:translateY(-1rem)}.il__toolbar.il--visible{transform:translateY(0)}}.il__tooltip{position:absolute;border-radius:0.5rem;background:var(--il__tooltip-backgroundColor);color:var(--il__tooltip-color);padding:0.25rem 0.5rem;top:100%;opacity:0;transition:opacity 0.3s ease,transform 0.3s ease;will-change:opacity,transform;transform:translateY(0) translateX(-50%);font-size:14px;white-space:nowrap;font-weight:bold;pointer-events:none;box-shadow:0 0 1rem rgba(0,0,0,0.1)}.il__tooltip.il--visible{transform:translateY(0.5rem) translateX(-50%);opacity:1}.il__dropdown{position:absolute;border-radius:0.5rem;background:var(--il__dropdown-backgroundColor);color:var(--il__dropdown-color);box-shadow:0 0 1rem rgba(0,0,0,0.1);opacity:0;transition:opacity 0.3s ease,transform 0.3s ease;will-change:opacity,transform;transform:translateY(0) translateX(-50%);pointer-events:none;outline:0}.il__dropdown.il--visible{transform:translateY(0.5rem) translateX(-50%);opacity:1;pointer-events:auto}.il__dropdown--link{padding:0.5rem;width:16rem}.il__dropdown--link input.il__input{padding:0.75rem;border-radius:0.5rem;background:var(--il__input-backgroundColor);color:var(--il__input-color);margin:0.125rem;width:calc(100% - (.125rem * 2))}.il__dropdown--link .il__footer{display:flex;align-items:center;justify-content:center}.il__dropdown--link .il__footer button.il__button{flex:1}.il__dropdown--link .il__footer button.il__button--cancel{background:var(--il__button-cancel-backgroundColor);color:var(--il__button-cancel-color)}.il__dropdown--link .il__footer button.il__button--cancel:focus,.il__dropdown--link .il__footer button.il__button--cancel:hover{background:var(--il__button-cancel-hover-backgroundColor);color:var(--il__button-cancel-hover-color)}.il__dropdown--link .il__footer button.il__button--confirm{background:var(--il__button-confirm-backgroundColor);color:var(--il__button-confirm-color)}.il__dropdown--link .il__footer button.il__button--confirm:focus,.il__dropdown--link .il__footer button.il__button--confirm:hover{background:var(--il__button-confirm-hover-backgroundColor);color:var(--il__button-confirm-hover-color)}.il__dropdown--color{padding:0.5rem;width:10rem}.il__dropdown--color input.il__input{padding:0.75rem;border-radius:0.5rem;background:var(--il__input-backgroundColor);color:var(--il__input-color);margin:0.125rem;width:calc(100% - (.125rem * 2));margin-bottom:0.5rem}.il__dropdown--color .il__group{display:flex;flex-wrap:wrap}.il__dropdown--color .il__group button{margin:0;flex:0 0 20%;max-width:20%;padding:0.1rem;cursor:pointer;position:relative}.il__dropdown--color .il__group button.il--resetStyle{color:var(--il__button-reset-color)}.il__dropdown--color .il__group button.il--resetStyle:after{background-color:transparent;box-shadow:inset 0 0 0 2px currentColor}.il__dropdown--color .il__group button.il--resetStyle:before{content:"";position:absolute;top:50%;left:50%;width:0.75rem;height:2px;transform:translate(-50%,-50%);background-color:currentColor;transition:transform 0.3s ease;will-change:transform}.il__dropdown--color .il__group button:not(.il--resetStyle):focus:after,.il__dropdown--color .il__group button:not(.il--resetStyle):hover:after{transform:scale(0.75)}.il__dropdown--color .il__group button:after{display:block;content:"";padding-bottom:99%;background-color:currentColor;border-radius:4rem;transition:transform 0.3s ease;will-change:transform}.il__panel{position:absolute;top:0;left:50%;transform:translateX(-45%);opacity:0;transition:opacity 0.3s ease,transform 0.3s ease;will-change:opacity,transform;pointer-events:none;background:var(--il__panel-backgroundColor);color:var(--il__panel-color);box-shadow:0 0.5rem 1.5rem rgba(0,0,0,0.2);border-radius:0.5rem;overflow:hidden;outline:0;max-width:calc(100vw - 2rem)}.il__panel:after,.il__panel:before{content:"";position:absolute;width:3rem;top:0;height:100%;pointer-events:none;background:var(--il__panel-backgroundColor);opacity:0;visibility:hidden;transition:opacity 0.3s ease,visibility 0.3s ease;will-change:opacity}.il__panel:before{left:-3rem;box-shadow:1rem 0 2rem 0.75rem var(--il__panel-backgroundColor)}.il__panel:after{right:-3rem;box-shadow:-1rem 0 2rem 0.75rem var(--il__panel-backgroundColor)}.il__panel--left:before,.il__panel--right:after{opacity:1;visibility:visible}.il__panel__container{display:flex;align-items:center;padding:0.25rem;overflow-x:auto;width:100%}@media (max-width:767px){.il__panel{box-shadow:0 0.5rem 1.5rem rgba(0,0,0,0.2),0 0 0 1px rgba(0,0,0,0.1)}}.il__panel.il--visible{transform:translateX(-50%);opacity:1;pointer-events:auto}.il__panel.il--hidden{transform:translateX(-55%);opacity:0;pointer-events:none}.il__panel button.il__button:last-child:after{content:"";position:absolute;height:100%;width:2.5rem;display:inline-block;margin-left:1rem}button.il__button{flex-shrink:0;flex:0 0 2.5rem;width:2.5rem;height:2.5rem;border-radius:0.5rem;display:flex;align-items:center;justify-content:center;cursor:pointer;margin:0.125rem;border:1px solid transparent}button.il__button[style*=rgb]{background-color:currentColor!important}button.il__button[style*=rgb] svg{color:rgba(0,0,0,0.75)}button.il__button[style*=rgb].il--light svg{color:rgba(255,255,255,0.75)}button.il__button svg{width:1.25rem;height:1.25rem;flex-shrink:0}button.il__button.il--open{background:var(--il__button-open-backgroundColor);color:var(--il__button-open-color)}button.il__button.il--active,button.il__button.il--active:hover{background:var(--il__button-active-backgroundColor);color:var(--il__button-active-color)}button.il__button:not(.il--active):focus,button.il__button:not(.il--active):hover{background:var(--il__button-hover-backgroundColor);color:var(--il__button-hover-color)}'
                    )
                ),
            this.contentWindow.document.addEventListener("mousedown", q.onBlur),
            q.options.customCSS)
        ) {
            var e = this.contentWindow.document.createElement("link");
            (e.rel = "stylesheet"), (e.href = q.options.customCSS), this.contentWindow.document.getElementsByTagName("head")[0].appendChild(e);
        }
        "contentEditable" in $.trigger ? ($.trigger.contentEditable = !0) : "designMode" in this.contentWindow.document && (this.contentWindow.document.designMode = "on");
    }
    function t(e) {
        var t = O("div", { class: "il__panel il__panel--" + e.id + " " + (e.class || "") + " il--" + q.options.theme, "aria-label": e.label, tabIndex: 0 }),
            n = O("div", { class: "il__panel__container" });
        return (
            t.appendChild(n),
            setTimeout(function () {
                n.addEventListener("scroll", F), F.call(n);
            }, 10),
            t
        );
    }
    function n() {
        var e = D();
        if (e && $.toolbar) {
            var t = $.toolbar.querySelector(".il__panel.il--visible:not(.il--hidden)").getBoundingClientRect(),
                n = { top: e.offset.top + e.offset.height + 4, left: e.offset.left + e.offset.width / 2 };
            n.left - t.width / 2 < 0 && (n.left = t.width / 2 + 16),
                n.left + t.width / 2 > q.window.innerWidth && (n.left = q.window.innerWidth - t.width / 2 - 16),
                n.top + t.height > q.window.innerHeight && (n.top = e.offset.top - t.height - 4),
                n.top < 0 && (n.top = 16),
                ($.toolbar.style.top = n.top + "px"),
                ($.toolbar.style.left = n.left + "px");
        }
    }
    function i() {
        if ((a(), ($.selection = D()), $.selection)) {
            $.toolbar = O("div", { class: "il__toolbar il--" + q.options.theme, role: "application" });
            var e = v();
            $.toolbar.appendChild(e), $.iframe.contentWindow.document.body.appendChild($.toolbar), o(), ($.iframe.style.display = "block");
        }
    }
    function a(e) {
        if ($.toolbar) {
            var t = $.toolbar;
            ($.toolbar = !1),
                M(),
                t.classList.remove("il--visible"),
                setTimeout(function () {
                    t.remove(), ($.iframe.style.display = "none"), r(), e && e();
                }, 400);
        }
    }
    function r() {
        q.window.removeEventListener("resize", q.onResize), q.window.removeEventListener("scroll", q.onScroll), $.trigger.removeEventListener("scroll", q.onScroll), q.options.onToolbarClose && q.options.onToolbarClose($);
    }
    function o() {
        (q.onResize = function () {
            n();
        }),
            q.window.addEventListener("resize", q.onResize),
            (q.timeout = !1),
            (q.onScroll = function () {
                if ($.dropdown) return !1;
                $.toolbar &&
                    ($.toolbar.classList.remove("il--visible"),
                    clearInterval(q.timeout),
                    (q.timeout = setTimeout(function () {
                        $.toolbar && (n(), $.toolbar.classList.add("il--visible"));
                    }, 250)));
            }),
            q.window.addEventListener("scroll", q.onScroll),
            $.trigger.addEventListener("scroll", q.onScroll),
            setTimeout(function () {
                n(), $.toolbar.classList.add("il--visible"), q.options.onToolbarOpen && q.options.onToolbarOpen($, D());
            }, 10);
    }
    function s(e, t) {
        var n = D(),
            i = !1;
        if (t.command) {
            switch (t.command) {
                case "insertUnorderedList":
                    i = T(n.node, "ul");
                    break;
                case "insertUnorderedList":
                    i = T(n.node, "ol");
                    break;
                case "bold":
                    i = T(n.node, "strong") || T(n.node, "b");
                    break;
                default:
                    i = document.queryCommandState(t.command);
            }
            i && "underline" == t.id && (i = !T(n.node, "a"));
        }
        t.tag && (i = S(n.node, t.tag)), (t.tag || t.command) && (i ? (e.classList.add("il--active"), e.setAttribute("aria-pressed", "true")) : (e.classList.remove("il--active"), e.setAttribute("aria-pressed", "false")));
    }
    function l(e) {
        return (
            '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="4.5">' + e + "</g></svg>"
        );
    }
    function d(e) {
        e.html;
        var t = { class: "il__button il__button--" + e.id + " " + (e.class || ""), tabIndex: 0, "aria-label": e.label, role: "button", "aria-pressed": "false" };
        e.svg && (t.html = l(e.svg)), e.html && (t.html = e.html);
        var n = O("button", t);
        return (
            s(n, e),
            e.label &&
                n.addEventListener("mouseenter", function () {
                    y({ text: e.label, target: n });
                }),
            (n.onclick = function () {
                if (($.dropdown && !$.dropdown.contains(n) && $.dropdown.exit(), e.onclick && e.onclick(n), e.tag)) {
                    var t = S(D().node, e.tag);
                    t ? (A(t), n.classList.remove("il--active")) : (B(e.tag), n.classList.add("il--active")), a();
                }
                e.command && (q.document.execCommand("styleWithCSS", !1, !1), q.document.execCommand(e.command, !1, null), s(n, e));
            }),
            n
        );
    }
    function c(e) {
        var t = !1;
        switch (e.id) {
            case "align":
                t = h(e);
                break;
            case "link":
                t = p(e);
                break;
            case "color":
                t = f(e);
        }
        return t;
    }
    function u(e) {
        return d({ svg: '<path d="M17 24h16M23 33.9L13.1 24l9.9-9.9"/>', label: q.options.labels.back, id: "back", onclick: e });
    }
    function p(e) {
        var t = D(),
            n = T(t.node, "a"),
            i = !!n && S(t.node, "a"),
            r = function () {
                $.dropdown.exit(), a();
            };
        e.onclick = function (e) {
            e.classList.contains("il--open")
                ? (e.classList.remove("il--open"), $.dropdown && $.dropdown.exit())
                : (e.classList.add("il--open"),
                  ($.dropdown = m({
                      label: q.options.labels.linkPanel,
                      target: e,
                      id: "link",
                      append: function (e) {
                          var t = function () {
                                  var e = a.value;
                                  if (!e.length) return a.focus(), C(a), !1;
                                  n ? i.setAttribute("href", e) : document.execCommand("CreateLink", !1, e), r();
                              },
                              a = O("input", { class: "il__input", value: i ? i.getAttribute("href") : "", placeholder: q.options.labels.linkPlaceholder });
                          a.addEventListener("keypress", function (e) {
                              13 == e.keyCode && t(), 27 == e.keyCode && $.dropdown.exit();
                          }),
                              e.appendChild(a),
                              setTimeout(function () {
                                  a.focus();
                              }, 10);
                          var o = O("div", { class: "il__footer" });
                          e.appendChild(o);
                          var s = {
                              cancel: {
                                  visible: n,
                                  id: "cancel",
                                  label: q.options.labels.removeLink,
                                  svg:
                                      '<path d="M16 24h16M19 34.221h-3.731C9.598 34.221 5 29.624 5 23.952c0-5.177 3.83-9.459 8.812-10.166M35.798 33.734c4.138-1.325 7.134-5.204 7.134-9.782 0-5.671-4.598-10.268-10.269-10.268h-3.731M7 7l34 34"/>',
                                  onclick: function () {
                                      A(i), r(), q.onChange();
                                  },
                              },
                              confirm: {
                                  visible: !0,
                                  id: "confirm",
                                  label: q.options.labels.confirmLink,
                                  svg:
                                      '<path d="M16 24h16M19 34.221h-3.731C9.598 34.221 5 29.624 5 23.952c0-5.671 4.598-10.268 10.269-10.268H19M28.932 34.221h3.731c5.671 0 10.269-4.597 10.269-10.269 0-5.671-4.598-10.268-10.269-10.268h-3.731"/>',
                                  onclick: function () {
                                      t();
                                  },
                              },
                          };
                          Object.keys(s).forEach(function (e) {
                              var t = s[e];
                              if (t.visible) {
                                  var n = d(t);
                                  o.appendChild(n);
                              }
                          });
                      },
                  })));
        };
        var o = d(e);
        return n && o.classList.add("il--active"), o;
    }
    function f(e) {
        var n = {
            textColor: {
                class: "il--unstyled il--colorPicker",
                id: "textColor",
                label: q.options.labels.textColor,
                property: "color",
                html:
                    '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"><g fill="none" fill-rule="evenodd"><rect class="line" width="26" height="4" x="11" y="37" fill="currentColor" rx="2"/><g stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="4.5"><path d="M14 31l9.03-19.995a1 1 0 011.821-.004L34 31h0M19 22.5h10"/></g></g></svg>',
                onclick: function (e) {
                    b({ id: "textColor", target: e, command: "foreColor", property: "color" });
                },
            },
            backgroundColor: {
                class: "il--unstyled il--colorPicker",
                id: "backgroundColor",
                label: q.options.labels.backgroundColor,
                property: "background-color",
                html:
                    '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="4.5"><path d="M30.816 7.946l8.836 8.836-17.09 19.679-11.425-11.424zM12.299 35.299L8.718 38.88"/><path d="M30.157 38.88h10" class="line" /></g></svg>',
                onclick: function (e) {
                    b({ id: "backgroundColor", target: e, command: "hilitecolor", property: "background-color" });
                },
            },
        };
        return (
            (e.onclick = function (i) {
                var a = D();
                e.panel.classList.add("il--hidden");
                var r = t({ label: q.options.labels.colorPanel, id: e.id }),
                    o = u(function () {
                        r.classList.remove("il--visible"),
                            setTimeout(function () {
                                r.remove();
                            }, 600),
                            e.panel.classList.remove("il--hidden"),
                            e.panel.focus();
                    });
                r.querySelector(".il__panel__container").appendChild(o),
                    Object.keys(n).forEach(function (e, t) {
                        var i = n[e],
                            o = d(i);
                        a && g(o, L(a.node, i.property)), r.querySelector(".il__panel__container").appendChild(o);
                    }),
                    $.toolbar.appendChild(r),
                    setTimeout(function () {
                        r.classList.add("il--visible"), r.focus();
                    }, 25);
            }),
            d(e)
        );
    }
    function g(e, t) {
        t && "rgba(0, 0, 0, 0)" != t && "rgb(0, 0, 0)" != t && (_(t) ? e.classList.remove("il--light") : e.classList.add("il--light"), (e.style.color = t));
    }
    function h(e) {
        var n = {
                justifyLeft: { id: "justifyLeft", label: q.options.labels.justifyLeft, svg: '<path d="M11 14h26M11 24.5h16M11 35h6"/>', command: "justifyLeft" },
                justifyCenter: { id: "justifyCenter", label: q.options.labels.justifyCenter, svg: '<path d="M11 14h26M16 24.5h16M21 35h6"/>', command: "justifyCenter" },
                justifyRight: { id: "justifyRight", label: q.options.labels.justifyRight, svg: '<path d="M11 14h26M21 24.5h16M31 35h6"/>', command: "justifyRight" },
                justifyFull: { id: "justifyFull", label: q.options.labels.justifyFull, svg: '<path d="M11 14h26M11 24.5h26M11 35h18.023"/>', command: "justifyFull" },
            },
            i = !1;
        return (
            Object.keys(n).forEach(function (e, t) {
                q.document.queryCommandState(e) && (i = e);
            }),
            D(),
            (e.svg = n[i].svg),
            (e.onclick = function (i) {
                e.panel.classList.add("il--hidden");
                var a = t({ label: q.options.labels.alignPanel, id: e.id }),
                    r = u(function () {
                        a.classList.remove("il--visible"),
                            setTimeout(function () {
                                a.remove();
                            }, 600),
                            e.panel.classList.remove("il--hidden"),
                            e.panel.focus();
                    });
                a.querySelector(".il__panel__container").appendChild(r),
                    Object.keys(n).forEach(function (e, t) {
                        var r = n[e];
                        r.onclick = function () {
                            a.querySelectorAll("button").forEach(function (e, t) {
                                e.classList.remove("il--active");
                            }),
                                (i.innerHTML = l(r.svg));
                        };
                        var o = d(r);
                        s(o, r), a.querySelector(".il__panel__container").appendChild(o);
                    }),
                    $.toolbar.appendChild(a),
                    setTimeout(function () {
                        a.classList.add("il--visible"), a.focus();
                    }, 25);
            }),
            d(e)
        );
    }
    function m(e) {
        var t = e.target.getBoundingClientRect(),
            n = O("div", { class: "il__dropdown il__dropdown--" + e.id + " " + (e.class || "") + " il--" + q.options.theme, "aria-label": e.label, role: "application", tabIndex: 0 });
        e.append && e.append(n),
            $.iframe.contentWindow.document.body.appendChild(n),
            setTimeout(function () {
                n.focus();
            }, 10),
            (function () {
                var e = n.getBoundingClientRect(),
                    i = { top: t.top + t.height, left: t.left + t.width / 2 };
                i.left < 0 && (i.left = 16),
                    i.left + e.width / 2 > q.window.innerWidth && (i.left = q.window.innerWidth - e.width / 2 - 16),
                    i.top + e.height + 32 > q.window.innerHeight && (i.top = t.top - e.height - 16),
                    i.top < 0 && (i.top = 16),
                    (n.style.top = i.top + "px"),
                    (n.style.left = i.left + "px");
            })();
        var i = function () {
                ($.dropdown = !1),
                    n.classList.remove("il--visible"),
                    e.target.classList.remove("il--open"),
                    setTimeout(function () {
                        q.window.removeEventListener("resize", o), q.window.removeEventListener("scroll", r), $.iframe.contentWindow.document.removeEventListener("mousedown", a), n.remove();
                    }, 600);
            },
            a = function (t) {
                t.target == e.target || e.target.contains(t.target) || t.target == n || n.contains(t.target) || n.exit();
            };
        Object.defineProperty(n, "exit", {
            value: function () {
                i();
            },
            configurable: !0,
        }),
            $.iframe.contentWindow.document.addEventListener("mousedown", a);
        var r = function () {
            if ($.dropdown) return !1;
            i();
        };
        q.window.addEventListener("scroll", r);
        var o = function () {
            i();
        };
        return (
            q.window.addEventListener("resize", o),
            setTimeout(function () {
                n.classList.add("il--visible");
            }, 10),
            n
        );
    }
    function b(e) {
        if (e.target.classList.contains("il--open")) e.target.classList.remove("il--open"), e.target.setAttribute("aria-pressed", "false"), $.dropdown && $.dropdown.exit();
        else {
            var t = function (t) {
                q.document.execCommand("styleWithCSS", !1, !0), q.document.execCommand(e.command, !1, t), g(e.target, t);
            };
            e.target.classList.add("il--open"),
                e.target.setAttribute("aria-pressed", "true"),
                ($.dropdown = m({
                    label: q.options.labels.colorPalette,
                    target: e.target,
                    id: "color",
                    append: function (n) {
                        var i = O("input", { class: "il__input", placeholder: "#000000" });
                        i.addEventListener("keypress", function (e) {
                            13 == e.keyCode && t(this.value);
                        }),
                            n.appendChild(i);
                        var a = O("div", { class: "il__group" });
                        n.appendChild(a);
                        var r = O("button", { class: "il--resetStyle", "aria-label": q.options.labels.removeStyle });
                        (r.onclick = function () {
                            (i.value = ""), e.target.setAttribute("style", ""), q.document.execCommand(e.command, !1, "inherit"), g(e.target, "");
                        }),
                            r.addEventListener("mouseenter", function () {
                                y({ text: q.options.labels.removeStyle, target: r });
                            }),
                            a.appendChild(r),
                            q.options.colors.forEach(function (e) {
                                var n = O("button", { "aria-label": e });
                                (n.style.color = e),
                                    (n.onclick = function () {
                                        (i.value = e), t(e);
                                    }),
                                    a.appendChild(n);
                            });
                    },
                }));
        }
    }
    function v() {
        var e = t({ id: "index", label: q.options.labels.indexPanel, class: "il--visible" }),
            n = {
                bold: { id: "bold", command: "bold", label: q.options.labels.bold, svg: '<path d="M14 10h9.68a7.04 7.04 0 010 14.08H14h0V10zM14 24.08h12.32a7.04 7.04 0 010 14.08H14h0V24.08z"/>' },
                italic: { id: "italic", command: "italic", label: q.options.labels.italic, svg: '<path d="M28.134 9.757l-7.61 28.401M31.219 9.757h-6.917M24.242 38.158h-6.917"/>' },
                underline: { id: "underline", command: "underline", label: q.options.labels.underline, svg: '<path d="M14 39h20M34 9.435v11.38C34 26.44 29.523 31 24 31s-10-4.56-10-10.186V9.435"/>' },
                strikeThrough: {
                    id: "strikeThrough",
                    command: "strikeThrough",
                    label: q.options.labels.strikeThrough,
                    svg: '<path d="M9 24h30M32.5 16.5c0-4.142-3.806-7.5-8.5-7.5s-8.5 3.358-8.5 7.5c0 4.142 3.806 7.5 8.5 7.5M15.5 31.5c0 4.142 3.806 7.5 8.5 7.5s8.5-3.358 8.5-7.5c0-4.142-3.806-7.5-8.5-7.5"/>',
                },
                unorderedList: {
                    id: "unorderedList",
                    command: "insertUnorderedList",
                    label: q.options.labels.unorderedList,
                    svg: '<path d="M22.5 32.5h13.177M22.5 15.5h13.177M13 32.5h1.78M13 15.5h1.78"/>',
                    onclick: function () {
                        $.toolbar.querySelector(".il__button--orderedList").classList.remove("il--active");
                    },
                },
                orderedList: {
                    id: "orderedList",
                    command: "insertOrderedList",
                    label: q.options.labels.orderedList,
                    svg: '<path d="M16.114 37h-5.12l4.475-6.08a1.959 1.959 0 00-.467-2.773 2.938 2.938 0 00-3.33-.003l-.003.003a1.89 1.89 0 00-.41 2.733M10.636 10h2.408v9.295M23.74 32.5h13.177M23.74 15.5h13.177"/>',
                    onclick: function () {
                        $.toolbar.querySelector(".il__button--unorderedList").classList.remove("il--active");
                    },
                },
                align: { id: "align", label: q.options.labels.align, custom: !0 },
                link: {
                    id: "link",
                    label: q.options.labels.link,
                    svg: '<path d="M16 24h16M19 34.221h-3.731C9.598 34.221 5 29.624 5 23.952c0-5.671 4.598-10.268 10.269-10.268H19M28.932 34.221h3.731c5.671 0 10.269-4.597 10.269-10.269 0-5.671-4.598-10.268-10.269-10.268h-3.731"/>',
                    custom: !0,
                },
                color: {
                    id: "color",
                    label: q.options.labels.color,
                    html:
                        '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"><g fill="none" fill-rule="evenodd" transform="translate(5 5)"><circle cx="15" cy="11" r="3" fill="currentColor"/><circle cx="23" cy="11" r="3" fill="currentColor"/><circle cx="29" cy="17" r="3" fill="currentColor"/><circle cx="9" cy="17" r="3" fill="currentColor"/><path stroke="currentColor" stroke-width="4.5" d="M19 0C8.444 0 0 8.444 0 19s8.444 19 19 19c1.689 0 3.167-1.478 3.167-3.167 0-.844-.211-1.477-.845-2.11-.422-.634-.844-1.267-.844-2.112 0-1.689 1.478-3.167 3.166-3.167h3.8C33.356 27.444 38 22.8 38 16.89 38 7.6 29.556 0 19 0z"/></g></svg>',
                    custom: !0,
                },
            };
        return (
            q.options.toolbar.forEach(function (t) {
                var i = n[t];
                if (i) {
                    i.panel = e;
                    var a = i.custom ? c(i) : d(i);
                    e.querySelector(".il__panel__container").appendChild(a);
                }
            }),
            e
        );
    }
    function y(e) {
        if (z()) return !1;
        var t = e.target ? e.target.getBoundingClientRect() : null,
            n = $.toolbar ? $.toolbar.getBoundingClientRect() : null;
        if (!t && !n) return !1;
        var i = O("div", { class: "il__tooltip", html: e.text });
        $.iframe.contentWindow.document.body.appendChild(i),
            (i.style.top = (t.top + t.height + i.offsetHeight + 8 > q.window.innerHeight ? n.top - i.offsetHeight - 8 : t.top + t.height) + "px"),
            (i.style.left = t.left + t.width / 2 + "px"),
            setTimeout(function () {
                i.classList.add("il--visible");
            }, 10);
        var a = function () {
            i.classList.remove("il--visible"),
                setTimeout(function () {
                    i.remove();
                }, 300);
        };
        e.target.addEventListener("mouseleave", a), $.iframe.contentWindow.document.addEventListener("mousedown", a);
    }
    function _(e) {
        var t = !1;
        return e.includes("rgb") ? (t = k(e)) : e.includes("#") && (t = e), E(t);
    }
    function w(e) {
        return [
            "FF",
            "FC",
            "FA",
            "F7",
            "F5",
            "F2",
            "F0",
            "ED",
            "EB",
            "E8",
            "E6",
            "E3",
            "E0",
            "DE",
            "DB",
            "D9",
            "D6",
            "D4",
            "D1",
            "CF",
            "CC",
            "C9",
            "C7",
            "C4",
            "C2",
            "BF",
            "BD",
            "BA",
            "B8",
            "B5",
            "B3",
            "B0",
            "AD",
            "AB",
            "A8",
            "A6",
            "A3",
            "A1",
            "9E",
            "9C",
            "99",
            "96",
            "94",
            "91",
            "8F",
            "8C",
            "8A",
            "87",
            "85",
            "82",
            "80",
            "7D",
            "7A",
            "78",
            "75",
            "73",
            "70",
            "6E",
            "6B",
            "69",
            "66",
            "63",
            "61",
            "5E",
            "5C",
            "59",
            "57",
            "54",
            "52",
            "4F",
            "4D",
            "4A",
            "47",
            "45",
            "42",
            "40",
            "3D",
            "3B",
            "38",
            "36",
            "33",
            "30",
            "2E",
            "2B",
            "29",
            "26",
            "24",
            "21",
            "1F",
            "1C",
            "1A",
            "17",
            "14",
            "12",
            "0F",
            "0D",
            "0A",
            "08",
            "05",
            "03",
            "00",
        ].reverse()[parseInt(e)];
    }
    function k(e) {
        var t = [];
        return (
            e.replace(/[\d+\.]+/g, function (e) {
                t.push(parseFloat(e));
            }),
            "#" + t.slice(0, 3).map(x).join("") + w(100 * (4 == t.length ? t[3] : 1))
        );
    }
    function x(e) {
        var t = e.toString(16);
        return 1 == t.length ? "0" + t : t;
    }
    function E(e) {
        const t = e.replace("#", "");
        return (299 * parseInt(t.substr(0, 2), 16) + 587 * parseInt(t.substr(2, 2), 16) + 114 * parseInt(t.substr(4, 2), 16)) / 1e3 > 155;
    }
    function C(e) {
        e.classList.add("il--rumble"),
            setTimeout(function () {
                e.classList.remove("il--rumble");
            }, 300);
    }
    function A(e) {
        for (var t = e.parentNode; e.firstChild; ) t.insertBefore(e.firstChild, e), e && e.remove();
    }
    function S(e, t) {
        return !!e.tagName && (e.tagName.toLowerCase() == t ? e : S(e.parentNode, t));
    }
    function T(e, t) {
        return !!(e && e.tagName && $.trigger.contains(e)) && (e.tagName.toLowerCase() == t || T(e.parentNode, t));
    }
    function M() {
        q.window.getSelection ? (q.window.getSelection().empty ? q.window.getSelection().empty() : q.window.getSelection().removeAllRanges && q.window.getSelection().removeAllRanges()) : q.document.selection && q.document.selection.empty(),
            ($.selection = !1);
    }
    function N(e) {
        try {
            return e instanceof HTMLElement;
        } catch (t) {
            return "object" == typeof e && 1 === e.nodeType && "object" == typeof e.style && "object" == typeof e.ownerDocument;
        }
    }
    function D() {
        var e = q.window.getSelection();
        if (!e.toString()) return !1;
        var t = e.getRangeAt(0).getBoundingClientRect(),
            n = I();
        return !!e.focusNode && { text: e.toString(), offset: t, node: n };
    }
    function L(e, t) {
        return !!N(e) && q.window.getComputedStyle(e, null).getPropertyValue(t);
    }
    function O(e, t) {
        (t = t || {}).attributes, t.style;
        var n = q.document.createElement(e);
        return (
            t &&
                Object.keys(t).forEach(function (e) {
                    var i = t[e];
                    switch (e) {
                        case "html":
                            n.innerHTML = i;
                            break;
                        case "style":
                            Object.keys(i).forEach(function (e) {
                                n.style[e] = i[e];
                            });
                            break;
                        default:
                            n.setAttribute(e, i);
                    }
                }),
            n
        );
    }
    function R(e, t) {
        for (var n in t)
            try {
                t[n].constructor == Object ? (e[n] = R(e[n], t[n])) : (e[n] = t[n]);
            } catch (i) {
                e[n] = t[n];
            }
        return e;
    }
    function j(e) {
        var t = q.document.createElement("style");
        return (t.type = "text/css"), t.styleSheet ? (t.styleSheet.cssText = e) : t.appendChild(q.document.createTextNode(e)), t;
    }
    function I(e) {
        var t, n, i;
        return document.selection
            ? ((t = document.selection.createRange()).collapse(e), t.parentElement())
            : ((n = window.getSelection()).getRangeAt
                  ? n.rangeCount > 0 && (t = n.getRangeAt(0))
                  : ((t = document.createRange()).setStart(n.anchorNode, n.anchorOffset),
                    t.setEnd(n.focusNode, n.focusOffset),
                    t.collapsed !== n.isCollapsed && (t.setStart(n.focusNode, n.focusOffset), t.setEnd(n.anchorNode, n.anchorOffset))),
              t ? (3 === (i = t[e ? "startContainer" : "endContainer"]).nodeType ? i.parentNode : i) : void 0);
    }
    function B(e) {
        var t = q.document.all ? q.document.selection.createRange().text : q.document.getSelection(),
            n = t.toString(),
            i = document.createElement(e);
        i.textContent = n;
        var a = t.getRangeAt(0);
        a.deleteContents(), a.insertNode(i);
    }
    function z() {
        return "ontouchstart" in window || navigator.maxTouchPoints > 0 || navigator.msMaxTouchPoints > 0;
    }
    function F() {
        if (this.scrollWidth > this.parentNode.offsetWidth + 1) {
            var e = this.scrollWidth - this.parentNode.offsetWidth;
            this.scrollLeft > 0 ? this.parentNode.classList.add("il__panel--left") : this.parentNode.classList.remove("il__panel--left"),
                this.scrollLeft < e ? this.parentNode.classList.add("il__panel--right") : this.parentNode.classList.remove("il__panel--right");
        } else this.parentNode.classList.remove("il__panel--left"), this.parentNode.classList.remove("il__panel--right");
    }
    function P() {
        z()
            ? ((q.onSelectionChange = function (e) {
                  clearInterval(q.timeout),
                      (q.timeout = setTimeout(function () {
                          e.target.activeElement == $.trigger && i();
                      }, 350));
              }),
              q.document.addEventListener("selectionchange", q.onSelectionChange))
            : ((q.timeout = !1),
              (q.onMouseUp = function (e) {
                  clearInterval(q.timeout),
                      (q.timeout = setTimeout(function () {
                          i();
                      }, 10));
              }),
              (q.onKeyUp = function (e) {
                  clearInterval(q.timeout),
                      (q.timeout = setTimeout(function () {
                          i();
                      }, 350));
              }),
              $.trigger.addEventListener("mouseup", q.onMouseUp),
              $.trigger.addEventListener("keyup", q.onKeyUp));
    }
    var $ = {};
    ($.trigger = !!arguments[0] && document.querySelector(arguments[0])),
        ($.set = function (e) {
            e && (q.options = R(q.options, e)), a();
        }),
        ($.destroy = function () {
            var e = function () {
                q.onMouseUp && $.trigger.removeEventListener("mouseup", q.onMouseUp),
                    q.onKeyUp && $.trigger.removeEventListener("mouseup", q.onKeyUp),
                    q.onSelectionChange && q.document.removeEventListener("selectionchange", q.onSelectionChange),
                    q.textarea && ($.trigger.remove(), ($.output.style.display = "inherit")),
                    $.iframe.remove(),
                    q.options.onDestroy && q.options.onDestroy(),
                    (q = !1),
                    ($ = !1);
            };
            $.toolbar
                ? a(function () {
                      e();
                  })
                : e();
        });
    var q = {
        options: {
            autoInit: !0,
            theme: "light",
            output: !1,
            html: !1,
            toolbar: ["bold", "italic", "underline", "strikeThrough", "align", "unorderedList", "orderedList", "color", "link"],
            colors: ["#199AA8", "#ABD356", "#F9C909", "#F45945", "#222C3A", "#4A5360", "#727985", "#99A0AB", "#C1C6D0"],
            labels: {
                back: "Back",
                indexPanel: "inLine editor toolbar",
                bold: "Bold",
                italic: "Italic",
                underline: "Underline",
                strikeThrough: "Strike",
                unorderedList: "Unordered list",
                orderedList: "Ordered list",
                align: "Align",
                alignPanel: "Align panel",
                justifyLeft: "Left",
                justifyCenter: "Center",
                justifyRight: "Right",
                justifyFull: "Justified",
                link: "Link",
                color: "Color",
                colorPanel: "Color panel",
                colorPalette: "Color palette",
                textColor: "Text color",
                backgroundColor: "Background color",
                linkPlaceholder: "Your link here",
                linkPanel: "Link panel",
                removeLink: "Remove link",
                confirmLink: "Confirm link",
                removeStyle: "Remove style",
            },
            onChange: !1,
            onReady: !1,
            onDestroy: !1,
            onToolbarOpen: !1,
            onToolbarClose: !1,
        },
    };
    if (
        (arguments[1] && (q.options = R(q.options, arguments[1])),
        (q.document = $.trigger.ownerDocument),
        (q.window = q.document.defaultView || q.document.parentWindow),
        (q.onChange = function (e, t) {
            ($.content = $.trigger.innerHTML), $.output && ($.output.value = $.content), !t && q.options.onChange && q.options.onChange($);
        }),
        $.trigger.tagName && ["TEXTAREA", "DIV"].includes($.trigger.tagName))
    )
        return (
            "TEXTAREA" == $.trigger.tagName &&
                ((q.textarea = !0),
                ($.output = $.trigger),
                ($.trigger = q.document.createElement("div")),
                ($.trigger.innerHTML = $.output.value),
                $.output.parentNode.insertBefore($.trigger, $.output.nextSibling),
                $.output.classList.add("il__output"),
                ($.output.style.display = "none")),
            "DIV" == $.trigger.tagName && ($.trigger.setAttribute("contenteditable", !0), $.trigger.classList.add("il__trigger"), q.options.output && ($.output = q.document.querySelector(q.options.output))),
            "spellcheck" in $.trigger && ($.trigger.spellcheck = !1),
            q.options.html && ($.trigger.innerHTML = q.options.html),
            $.output && (q.onChange(null, !0), $.trigger.addEventListener("input", q.onChange)),
            ($.iframe = O("iframe", { class: "il__frame", style: { width: "100%", height: "100%", border: 0, position: "fixed", top: 0, left: 0, display: "none", zIndex: 2147483647 } })),
            ($.iframe.onload = function () {
                e.call(this);
            }),
            q.document.body.appendChild($.iframe),
            $.trigger && q.options.autoInit && P(),
            q.options.onReady && q.options.onReady($),
            $
        );
    console.error("Invalid selector, you can initialize inLine only on textarea or div tag.");
}
!(function () {
    this.dateDropper = function () {
        var e = dateDropper.prototype;
        e.fetch = function () {
            var e = document.querySelectorAll(t.options.selector);
            e.length &&
                e.forEach(function (e, n) {
                    t.prepare(e);
                });
        };
        var t = {};
        function n(e, t) {
            return [31, e % 4 != 0 || (e % 100 == 0 && e % 400 != 0) ? 28 : 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][t - 1];
        }
        function i(e) {
            return e < 10 ? "0" + e : e;
        }
        function a(e) {
            var t = ["th", "st", "nd", "rd"],
                n = e % 100;
            return e + (t[(n - 20) % 10] || t[n] || t[0]);
        }
        function r(e) {
            return Date.parse(e) / 1e3;
        }
        function o(e) {
            if (!e) return !1;
            var t = [];
            return (
                ("string" == typeof e || e instanceof String) && e.split("."),
                !!Array.isArray(e) &&
                    (e.forEach(function (e) {
                        t.push(r(new Date(e)));
                    }),
                    t)
            );
        }
        function s(e, t) {
            return !(!e || !t) && e.y == t.y && e.m == t.m && e.d == t.d;
        }
        function l(e) {
            return !!e && e.y + "/" + i(e.m) + "/" + i(e.d);
        }
        function d(e) {
            return !!e && new Date(l(e));
        }
        function c(e) {
            return !!e && { d: e.getDate(), m: e.getMonth() + 1, y: e.getFullYear() };
        }
        function u(e) {
            return l(c(e));
        }
        function p(e) {
            return !!e && new Date(e);
        }
        function f(e) {
            return c(p(e));
        }
        function g(e) {
            return !!e.arr && e.arr.includes(r(e.date));
        }
        function h(e) {
            e &&
                (e.classList.remove("dd-shown"),
                setTimeout(function () {
                    e.remove();
                }, 600));
        }
        function m(e, t) {
            var n = e.querySelectorAll("." + t);
            n &&
                n.forEach(function (e) {
                    e.classList.remove(t);
                });
        }
        function b(e, t) {
            e.setAttribute("data-dd-opt-default-date", l(t));
        }
        function v(e, t) {
            e && e instanceof HTMLInputElement && (e.value = t);
        }
        function y(e, t) {
            return Math.round((t - e) / 864e5);
        }
        function w(e, t) {
            var n = document.createElement(e);
            return t && (t.class && (n.className = t.class), t.html && (n.innerHTML = t.html), t.id && (n.id = t.id)), n;
        }
        function k(e) {
            e.classList.add("dd-rumble"),
                setTimeout(function () {
                    e.classList.remove("dd-rumble");
                }, 400);
        }
        function x(e, t) {
            for (var n in t)
                try {
                    t[n].constructor == Object ? (e[n] = _.extend(e[n], t[n])) : (e[n] = t[n]);
                } catch (i) {
                    e[n] = t[n];
                }
            return e;
        }
        function E(e) {
            return e
                .replace(/(?:^\w|[A-Z]|\b\w)/g, function (e, t) {
                    return 0 === t ? e.toLowerCase() : e.toUpperCase();
                })
                .replace(/\s+/g, "")
                .replace("-", "");
        }
        (t.options = { format: "y-mm-dd", lang: "en", blocks: ["m", "d", "y"], autoFill: !0, jump: 10, loopAll: !0, loopDays: !0, loopMonths: !0, loopYears: !0, highlightWeekend: !0, defaultBehavior: !0, showArrowsOnHover: !0 }),
            x(t.options, arguments[0]),
            (t.prepare = function (e) {
                if (e.classList.contains("dd__trigger")) return !1;
                e.classList.add("dd__trigger"), e instanceof HTMLInputElement && (e.setAttribute("readonly", !0), e.setAttribute("type", "text"));
                var n = t.methods(e);
                (n.triggerFunc = function () {
                    this.classList.contains("dd-focused") || this.datedropper("show");
                }),
                    e.addEventListener("click", n.triggerFunc);
            }),
            (t.destroy = function (e) {
                t.exit(e), e.trigger.removeEventListener("click", e.triggerFunc), delete e.trigger.datedropper, e.options.onDestroy && e.options.onDestroy(e.trigger);
            }),
            (t.methods = function (e) {
                var n = {};
                return (
                    (n.trigger = e),
                    Object.defineProperty(n.trigger, "datedropper", {
                        value: function (e, i) {
                            switch (e) {
                                case "show":
                                    t.open(n);
                                    break;
                                case "hide":
                                    t.exit(n);
                                    break;
                                case "destroy":
                                    t.destroy(n);
                                    break;
                                case "set":
                                    t.set(n, i);
                            }
                        },
                        configurable: !0,
                    }),
                    n
                );
            }),
            (t.set = function (e, n) {
                Object.keys(n).forEach(function (t) {
                    var i = t.replace(/[A-Z]/g, (e) => "-" + e.toLowerCase());
                    e.trigger.setAttribute("data-dd-opt-" + i, n[t]);
                }),
                    e.dropdown && t.open(e);
            }),
            (t.open = function (e) {
                e.dropdown && t.exit(e), (e.options = t.getOptions(e)), t.cleanOptions(e), t.dropdown(e), t.change(e, !0);
            }),
            (t.locked = function (e, t) {
                var n = e.dropdown.querySelector(".dd__primaryButton");
                t ? (k(n), n.setAttribute("disabled", "")) : n.removeAttribute("disabled");
            }),
            (t.dataOptions = function (e) {
                for (var t = e.trigger.attributes, n = t.length, i = {}; n--; ) {
                    var a = t[n];
                    if (a.value && a.name.includes("data-dd-opt-")) {
                        var r = E(a.name.replace("data-dd-opt-", "")),
                            o = a.value;
                        switch (o) {
                            case "true":
                                o = !0;
                                break;
                            case "false":
                                o = !1;
                        }
                        i[r] = o;
                    }
                }
                return i;
            }),
            (t.getOptions = function (e) {
                var n = x({}, t.options);
                switch (
                    ((n = x(n, t.dataOptions(e))),
                    ["maxYear", "minYear"].forEach(function (e) {
                        n[e] = n[e] || new Date().getFullYear() + ("maxYear" == e ? 50 : -50);
                    }),
                    ["maxDate", "minDate"].forEach(function (e) {
                        n[e] = "today" == n[e] ? u(new Date()) : n[e];
                    }),
                    (n.defaultDate = p(n.defaultDate) || new Date()),
                    (n.range = n.range || Boolean(n.rangeStart || n.rangeEnd)),
                    (n.expandedOnly = n.expandedOnly || n.range),
                    (n.expandedDefault = n.expandedDefault || n.expandedOnly),
                    (n.expandable = n.expandable || n.expandedDefault || n.doubleView),
                    ["onlyMonth", "onlyYear"].includes(n.preset) && ((n.range = !1), (n.defaultBehavior = !1), (n.expandable = !1), (n.customClass = (n.customClass || "") + " dd-preset-" + n.preset)),
                    n.preset)
                ) {
                    case "onlyMonth":
                        (n.blocks = ["m"]), (n.format = ["m", "mm", "M", "MM"].includes(n.format) ? n.format : "m");
                        break;
                    case "onlyYear":
                        (n.blocks = ["y"]), (n.format = "y");
                }
                return n;
            }),
            (t.fixDate = function (e, t) {
                var n = e.options.maxYear,
                    i = e.options.minYear,
                    a = t.input.getFullYear();
                return n && a > n && (a = t.fill ? n : i), i && a < i && (a = t.fill ? i : n), t.input.setFullYear(a), t.input;
            }),
            (t.cleanOptions = function (e) {
                (e.date = t.fixDate(e, { input: e.options.defaultDate, fill: !0 })),
                    e.options.rangeStart &&
                        e.options.rangeEnd &&
                        t.valid(e, p(e.options.rangeStart)) &&
                        t.valid(e, p(e.options.rangeEnd)) &&
                        p(e.options.rangeEnd) > p(e.options.rangeStart) &&
                        ((e.options.range = !0), (e.range = { a: f(e.options.rangeStart), b: f(e.options.rangeEnd) }), (e.date = d(e.range.a)), (e.selected = new Date(u(e.date)))),
                    e.options.range || (e.selected = new Date(u(e.date)));
            }),
            (t.lang = function (e) {
                var t = dateDropperSetup.languages;
                return t[e.options.lang] || t.en;
            }),
            (t.output = function (e, n) {
                var o = (n = n || {}).input || e.selected || e.date,
                    s = o.getFullYear(),
                    l = o.getMonth() + 1,
                    d = o.getDate(),
                    c = o.getDay(),
                    u = t.lang(e),
                    p = { d: d, dd: i(d), m: l, mm: i(l), M: u.m.s[l - 1], MM: u.m.f[l - 1], y: s, w: c, W: u.w.f[c].substr(0, 3), WW: u.w.f[c], S: a(d), U: r(o) };
                return (
                    (p.string = (n.format || e.options.format)
                        .replace(/\b(d)\b/g, p.d)
                        .replace(/\b(dd)\b/g, p.dd)
                        .replace(/\b(m)\b/g, p.m)
                        .replace(/\b(mm)\b/g, p.mm)
                        .replace(/\b(M)\b/g, p.M)
                        .replace(/\b(MM)\b/g, p.MM)
                        .replace(/\b(y)\b/g, p.y)
                        .replace(/\b(w)\b/g, p.w)
                        .replace(/\b(W)\b/g, p.W)
                        .replace(/\b(WW)\b/g, p.WW)
                        .replace(/\b(S)\b/g, p.S)
                        .replace(/\b(U)\b/g, p.U)),
                    p
                );
            }),
            (t.offset = function (e) {
                var n,
                    i,
                    a = document.querySelectorAll(t.options.selector),
                    r = e.trigger.getBoundingClientRect(),
                    o = e.dropdown.getBoundingClientRect(),
                    s = o.width / 2,
                    l = document.documentElement.scrollTop,
                    d = r.top + l;
                (n = d + r.height + o.height + 16 < l + window.innerHeight ? d + r.height + 16 : l + window.innerHeight - 16 - o.height), (e.dropdown.style.top = n + "px");
                var c = document.documentElement.scrollLeft;
                if (e.options.range && 2 == a.length) {
                    var u = a[0].getBoundingClientRect(),
                        p = a[1].getBoundingClientRect(),
                        f = c + u.left;
                    i = f + (c + p.left + p.width - f) / 2;
                } else i = r.left + c + r.width / 2;
                0 > i - s && (i = 16 + s), i + s + 16 > window.innerWidth && (i = window.innerWidth - 16 - s), (e.dropdown.style.left = i + "px");
            }),
            (t.block = function (e, n) {
                var i = w("div", { class: "dd__block", html: '<div class="dd__nav dd-left dd-hidden">' + t.svg("arrowLeft") + '</div><div class="dd__nav dd-right dd-hidden">' + t.svg("arrowRight") + '</div><div class="dd__view"></div>' });
                i.setAttribute("data-key", n),
                    i.querySelector(".dd-left").addEventListener("click", function () {
                        t.move(e, n, !1);
                    }),
                    i.querySelector(".dd-right").addEventListener("click", function () {
                        t.move(e, n, !0);
                    }),
                    e.options.defaultBehavior &&
                        i.querySelector(".dd__view").addEventListener("click", function () {
                            switch (n) {
                                case "y":
                                    t.yearDialog(e);
                                    break;
                                case "m":
                                    t.monthDialog(e);
                                    break;
                                case "d":
                                    t.toggleView(e);
                            }
                        }),
                    e.dropdown.appendChild(i);
            }),
            (t.toggleView = function (e) {
                e.options.expandable && ((e.expanded = !e.expanded), t.open(e));
            }),
            (t.calendarHeader = function (e) {
                for (var n = t.lang(e), i = w("div", { class: "dd__header" }), a = 0; a <= 6; a++) {
                    var r = a,
                        o = w("div", { class: "dd__item" });
                    e.options.startFromMonday && (r = r + 1 == 7 ? 0 : r + 1), (o.innerHTML = n.w.s[r]), i.appendChild(o);
                }
                return i;
            }),
            (t.validRange = function (e, t, n) {
                var i = !0,
                    a = y(t, n);
                return i && e.options.minRange && (i = a >= e.options.minRange), i && e.options.maxRange && (i = a <= e.options.maxRange), i;
            }),
            (t.setRange = function (e, n) {
                var i = n.date,
                    a = n.item;
                if (e.selecting) {
                    var r = d(e.range.a),
                        o = d(i);
                    if (o > r) {
                        if (!t.validRange(e, r, o)) return void k(a);
                        (e.range.b = i), (e.selecting = !1), e.options.onRangeSet && e.options.onRangeSet(t.prepareOutput(e));
                    } else e.range.a = i;
                } else (e.range = {}), (e.range.a = i), (e.selecting = !0), t.setDate(e, { d: i.d, m: i.m, y: i.y });
            }),
            (t.calendarDay = function (e, n) {
                var i = d(n.date),
                    a = w("div", { html: '<div class="dd-value">' + n.date.d + "</div>", class: "dd__item " + (n.class || "") });
                t.weekend(e, i.getDay()) && a.classList.add("dd-weekend");
                var o = s(c(new Date()), n.date),
                    l = s(c(e.selected), n.date);
                if ((!l && o && a.classList.add("dd-today"), e.options.range && e.range)) {
                    if (
                        (["a", "b"].forEach(function (t) {
                            e.range[t] && s(n.date, e.range[t]) && (e.range.a && e.range.b && a.classList.add("dd-" + t), a.classList.add("dd-selected"));
                        }),
                        e.range.a && e.range.b)
                    ) {
                        var u = r(d(e.range.a)),
                            p = r(d(e.range.b)),
                            f = r(i);
                        f > u && f < p && a.classList.add("dd-point");
                    }
                } else l && a.classList.add("dd-selected");
                if ((!e.range || e.range.b || t.validRange(e, d(e.range.a), d(n.date))) && t.valid(e, i)) {
                    var g = { item: a, date: n.date };
                    e.options.onRender && t.putOnSchema(e, g),
                        a.addEventListener("click", function () {
                            e.options.range ? t.setRange(e, g) : t.setDate(e, { d: n.date.d, m: n.date.m, y: n.date.y }), t.change(e, !0);
                        }),
                        e.options.range &&
                            (a.addEventListener("mouseenter", function () {
                                t.settingRange(e, g), e.dropdown.classList.add("dd-selecting"), a.classList.add("dd-selecting");
                            }),
                            a.addEventListener("mouseleave", function () {
                                m(e.dropdown, "dd-selecting"), m(e.dropdown, "dd-starting"), m(e.dropdown, "dd-perEnd"), m(e.dropdown, "dd-perStart");
                            }));
                } else a.classList.add("dd-disabled");
                return a;
            }),
            (t.putOnSchema = function (e, t) {
                var n = {
                    node: t.item,
                    customLabel: function (e) {
                        if ((t.item.setAttribute("data-dd-tooltip", e.label), e.color)) {
                            var n = w("div", { class: "dd-color" });
                            n.setAttribute("style", "background-color:" + e.color);
                        }
                        t.item.appendChild(n);
                    },
                };
                e.CSCHEMA[l(t.date)] = n;
            }),
            (t.settingRange = function (e, n) {
                if (e.range && e.range.a && !e.range.b && d(e.range.a) < d(n.date)) {
                    var i = n.item.parentNode.querySelector(".dd__item.dd-selected") || n.item.parentNode.querySelector(".dd__body .dd__item:first-of-type");
                    if (t.isDoubleView(e)) {
                        var a = n.item.parentNode.parentNode.previousSibling;
                        a && (a.querySelector(".dd__item.dd-selected") ? a.classList.add("dd-perEnd") : d(n.date).getMonth() != d(e.range.a).getMonth() && a.classList.add("dd-perStart"));
                    }
                    i.classList.add("dd-starting");
                }
            }),
            (t.calendarBody = function (e, i) {
                var a = w("div", { class: "dd__body" }),
                    r = i.date || t.output(e),
                    o = n(r.y, r.m),
                    s = r.y + "/" + r.m + "/01",
                    l = new Date(s);
                l.setDate(l.getDate() - 1);
                var d = new Date(s);
                d.setMonth(d.getMonth() + 1);
                var c = 42,
                    u = l.getDay() + (e.options.startFromMonday ? -1 : 0);
                if (6 != u) for (var p = u; p >= 0; p--) a.appendChild(t.calendarDay(e, { class: "dd-placeholder dd-before", date: { d: l.getDate() - p, m: l.getMonth() + 1, y: l.getFullYear() } })), c--;
                for (p = 1; p <= o; p++) a.appendChild(t.calendarDay(e, { class: "dd-i", date: { d: p, m: r.m, y: r.y } })), c--;
                for (p = 1; p <= c; p++) a.appendChild(t.calendarDay(e, { class: "dd-placeholder", date: { d: p, m: d.getMonth() + 1, y: d.getFullYear() } }));
                return a;
            }),
            (t.createCalendar = function (e, n) {
                var i = w("div");
                return i.appendChild(t.calendarHeader(e)), i.appendChild(t.calendarBody(e, n)), i;
            }),
            (t.calendar = function (e) {
                var n = e.dropdown.querySelector(".dd__calendar");
                if (!n) return !1;
                (n.innerHTML = ""), (e.CSCHEMA = {});
                var i = c(e.date);
                if ((n.appendChild(t.createCalendar(e, { date: i })), t.isDoubleView(e))) {
                    var a = d(i);
                    a.setMonth(a.getMonth() + 1), (a = c(a)), n.appendChild(t.createCalendar(e, { date: a }));
                }
            }),
            (t.prepareOutput = function (e) {
                return e.options.range ? { a: t.output(e, { input: e.range ? d(e.range.a) : e.selected }), b: t.output(e, { input: e.range ? d(e.range.b || e.range.a) : e.selected }) } : t.output(e);
            }),
            (t.save = function (e) {
                e.options.range ? t.saveValues(e) : t.saveValue(e), e.options.onChange && e.options.onChange({ trigger: e.trigger, dropdown: e.dropdown, output: t.prepareOutput(e) });
            }),
            (t.checkoutDay = function (e, t) {
                return e.options.checkout && ((t = d(t)).setDate(t.getDate() + 1), (t = c(t))), t;
            }),
            (t.saveValues = function (e) {
                var n = document.querySelectorAll(t.options.selector);
                e.range &&
                    ["a", "b"].forEach(function (i, a) {
                        var r = e.range[i] || t.checkoutDay(e, e.range.a);
                        if (
                            r &&
                            (n.forEach(function (e) {
                                var t = "data-dd-opt-range-" + ("a" == i ? "start" : "end");
                                e.setAttribute(t, l(r));
                            }),
                            2 == n.length && n[a])
                        ) {
                            var o = t.output(e, { input: d(r) });
                            b(n[a], o), v(n[a], o.string);
                        }
                    });
            }),
            (t.saveValue = function (e) {
                var n = t.output(e);
                b(e.trigger, n), v(e.trigger, n.string), e.options.changeValueTo && v(document.querySelector(e.options.changeValueTo), n.string);
            }),
            (t.change = function (e, n) {
                e.dropdown && (t.fillBlocks(e, { input: e.date }), e.options.expandable && e.expanded && t.calendar(e)),
                    t.valid(e) ? (t.locked(e, !1), e.options.autoFill && t.save(e)) : t.locked(e, !0),
                    n && e.expanded && e.options.onRender && e.options.onRender(e.CSCHEMA);
            }),
            (t.valid = function (e, t) {
                if (!(t = t || e.selected)) return t;
                var n = !0,
                    i = e.options.enabledDays,
                    a = e.options.disabledDays;
                n && !i && a && (n = !g({ date: t, arr: o(a) })), n && !a && i && (n = g({ date: t, arr: o(i) }));
                var s = e.options.maxDate,
                    l = e.options.minDate;
                n && l && (n = r(t) >= r(l)), n && s && (n = r(t) <= r(s));
                var d = e.options.disabledWeekDays;
                return n && d && (n = !d.includes(t.getDay())), n;
            }),
            (t.loopSet = function (e, t) {
                var n = !e.options.loopAll;
                switch (t) {
                    case "y":
                        n = n || !e.options.loopYears;
                        break;
                    case "m":
                        n = n || !e.options.loopMonths;
                        break;
                    case "d":
                        n = n || !e.options.loopDays;
                }
                return n;
            }),
            (t.lockedLoop = function (e, i, a) {
                var r = !0,
                    o = c(e.date);
                switch (i) {
                    case "y":
                        r = t.loopSet(e, "y") && o.y == (a ? e.options.maxYear : e.options.minYear);
                        break;
                    case "m":
                        r = t.loopSet(e, "m") && o.m == (a ? 12 : 1);
                        break;
                    case "d":
                        r = t.loopSet(e, "d") && o.d == (a ? n(o.y, o.m) : 1);
                }
                return r;
            }),
            (t.move = function (e, n, i) {
                var a = e.date,
                    r = i ? 1 : -1;
                if (t.lockedLoop(e, n, i)) return !1;
                switch (n) {
                    case "y":
                        a.setFullYear(a.getFullYear() + r);
                        break;
                    case "m":
                        a.setMonth(a.getMonth() + r);
                        break;
                    case "d":
                        a.setDate(a.getDate() + r);
                }
                (a = t.fixDate(e, { input: a })), e.expanded || (e.selected = new Date(u(e.date))), t.change(e, !0);
            }),
            (t.isDoubleView = function (e) {
                return e.options.doubleView && window.innerWidth > 768 ? (e.dropdown.classList.add("dd-doubleView"), !0) : (e.dropdown.classList.remove("dd-doubleView"), !1);
            }),
            (t.weekend = function (e, t) {
                return e.options.highlightWeekend && [0, 6].includes(t);
            }),
            (t.fillBlocks = function (e) {
                var n = t.output(e, { input: e.date }),
                    i = n.M;
                if (e.expanded && t.isDoubleView(e)) {
                    var a = new Date(u(e.date));
                    a.setMonth(a.getMonth() + 1), (i = i + " - " + (a = t.output(e, { input: a })).M);
                }
                var r = { y: "<div>" + n.y + "</div>", m: "<div>" + i + "</div>", d: "<div>" + n.dd + "</div><div " + (t.weekend(e, n.w) ? 'class="dd-w"' : "") + '">' + n.WW + "</div>" };
                e.options.blocks.forEach(function (t) {
                    e.dropdown.querySelector('.dd__block[data-key="' + t + '"] .dd__view').innerHTML = r[t];
                });
            }),
            (t.monthDialog = function (e) {
                t.dialog(e, {
                    onDom: function (n) {
                        for (var i = 0; i <= 11; i++) n.appendChild(t.monthDialogItem(e, { dialog: n, value: i, timeout: 50 * i }));
                    },
                });
            }),
            (t.monthDialogItem = function (e, n) {
                var i = t.lang(e);
                return t.dialogItem(e, {
                    class: "dd__item dd-hidden",
                    html: i.m.s[n.value],
                    timeout: n.timeout,
                    onClick: function () {
                        t.setDate(e, { m: n.value + 1 }, !0), t.change(e, !0), h(n.dialog);
                    },
                });
            }),
            (t.yearDialogLoop = function (e, n) {
                var i = 0;
                if (!n.init) {
                    var a = t.dialogItem(e, {
                        html: "...",
                        class: "dd__item dd-hidden",
                        timeout: 0,
                        onClick: function () {
                            h(n.dialog), t.yearDialog(e);
                        },
                    });
                    n.dialog.appendChild(a);
                }
                for (var r = n.min; r <= n.max; r++)
                    if (!n.multiple || (n.multiple && r % n.multiple == 0)) {
                        var o = t.yearDialogItem(e, { dialog: n.dialog, value: r, init: n.init, timeout: 50 * i });
                        n.dialog.appendChild(o), i++;
                    }
            }),
            (t.yearDialog = function (e) {
                t.dialog(e, {
                    onDom: function (n) {
                        t.yearDialogLoop(e, { min: e.options.minYear, max: e.options.maxYear, multiple: e.options.jump, dialog: n, init: !0 });
                    },
                });
            }),
            (t.yearDialogItem = function (e, n) {
                return t.dialogItem(e, {
                    html: n.value,
                    class: "dd__item dd-hidden",
                    timeout: n.timeout,
                    onClick: function () {
                        n.init ? ((n.dialog.innerHTML = ""), (n.dialog.scrollTop = 0), t.yearDialogLoop(e, { min: n.value, max: n.value + 10, dialog: n.dialog })) : (t.setDate(e, { y: n.value }, !0), t.change(e, !0), h(n.dialog));
                    },
                });
            }),
            (t.setDate = function (e, t, n) {
                var i = c(e.selected || e.date);
                (e.selected = new Date((t.y || i.y) + "/" + (t.m || i.m) + "/" + (t.d || i.d))), (!n && e.expanded) || (e.date = new Date(u(e.selected)));
            }),
            (t.dialogItem = function (e, t) {
                var n = w("div", { class: t.class, html: t.html });
                return (
                    t.onClick && n.addEventListener("click", t.onClick),
                    setTimeout(function () {
                        n.classList.add("dd-shown");
                    }, t.timeout || 0),
                    n
                );
            }),
            (t.dialog = function (e, t) {
                var n = w("div", { class: "dd__dialog dd-hidden" });
                t.onDom && t.onDom(n);
                var i = w("div", { class: "dd__footer" });
                i.addEventListener("click", function () {
                    h(n);
                }),
                    n.appendChild(i),
                    e.dropdown.appendChild(n),
                    setTimeout(function () {
                        n.classList.add("dd-shown");
                    }, 50);
            }),
            (t.dropdown = function (e) {
                e.trigger.classList.add("dd-focused"),
                    (e.dropdown = w("div", { class: "dd__dropdown dd-hidden " + (e.options.customClass || "") + (e.options.showArrowsOnHover ? " dd-arw-hover" : ""), id: "datedropper" })),
                    e.options.overlay && ((e.overlay = w("div", { class: "dd__overlay dd-hidden" })), document.body.appendChild(e.overlay)),
                    e.options.blocks.forEach(function (n) {
                        t.block(e, n);
                    });
                var n = w("div", { class: "dd__footer" });
                e.dropdown.appendChild(n);
                var i = w("div", { class: "dd__primaryButton", html: t.svg("checkmark") });
                if (
                    (i.addEventListener("click", function () {
                        t.save(e), t.exit(e);
                    }),
                    n.appendChild(i),
                    e.options.expandable)
                ) {
                    if (!e.options.expandedOnly) {
                        var a = w("div", { class: "dd__expandButton", html: e.expanded ? t.svg("reduce") : t.svg("expand") });
                        a.addEventListener("click", function () {
                            t.toggleView(e);
                        }),
                            e.dropdown.appendChild(a);
                    }
                    if (((e.expanded = !(void 0 !== e.expanded || !e.options.expandedDefault) || e.expanded), e.expanded)) {
                        e.dropdown.classList.add("dd-expanded"), t.isDoubleView(e);
                        var r = e.dropdown.querySelector("[data-key=d]");
                        if (r) {
                            var o = w("div", { class: "dd__calendar" });
                            r.parentNode.insertBefore(o, r);
                        }
                    }
                }
                document.body.appendChild(e.dropdown),
                    (e.onResize = function (n) {
                        if ((t.offset(e), e.expanded && e.options.doubleView)) {
                            var i = e.dropdown.classList.contains("dd-doubleView");
                            ((window.innerWidth < 768 && i) || (window.innerWidth > 768 && !i)) && e.trigger.datedropper("show");
                        }
                    }),
                    (e.onBlur = function (n) {
                        (n = n || window.event).target == e.trigger || n.target == e.dropdown || e.dropdown.contains(n.target) || t.exit(e);
                    }),
                    document.addEventListener("mousedown", e.onBlur),
                    window.addEventListener("resize", e.onResize),
                    setTimeout(function () {
                        t.offset(e),
                            e.dropdown.classList.add("dd-shown"),
                            e.overlay && e.overlay.classList.add("dd-shown"),
                            e.options.onDropdownOpen && e.options.onDropdownOpen({ trigger: e.trigger, dropdown: e.dropdown, output: t.prepareOutput(e) });
                    }, 50);
            }),
            (t.svg = function (e) {
                return (
                    '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">' +
                    {
                        arrowLeft: '<path d="M16 21l-9-9 9-9"/>',
                        arrowRight: '<path d="M7 21l9-9-9-9"/>',
                        checkmark: '<path d="M2.998 11.049l6.965 6.942 11.035-11"/>',
                        close: '<path d="M5.5 5.5l13 13M18.5 5.5l-13 13"/>',
                        expand:
                            '<g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-width="2"><path stroke-linecap="square" d="M19 5l-4.643 4.643"/><path d="M12 4h8v8"/><path stroke-linecap="square" d="M5 19l4.643-4.643"/><path d="M12 20H4v-8"/></g>',
                        reduce:
                            '<g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-width="2"><path stroke-linecap="square" d="M4 21l6-6"/><path d="M3 14h8v8"/><path stroke-linecap="square" d="M21 3l-6 6"/><g><path d="M22 10h-8V2"/></g></g>',
                    }[e] +
                    "</svg>"
                );
            }),
            (t.exit = function (e) {
                h(e.dropdown),
                    h(e.overlay),
                    (e.dropdown = !1),
                    e.options.onDropdownExit && e.options.onDropdownExit({ trigger: e.trigger, dropdown: e.dropdown, output: t.prepareOutput(e) }),
                    document.removeEventListener("mousedown", e.onBlur),
                    window.removeEventListener("resize", e.onResize),
                    e.trigger.classList.remove("dd-focused");
            }),
            e.fetch();
    };
    var e = document.createElement("style"),
        t =
            ':root{--dd-overlay:rgba(0,0,0,.75);--dd-background:#FFFFFF;--dd-text1:#333333;--dd-text2:#FFFFFF;--dd-primary:#4bc6f9;--dd-gradient:linear-gradient(45deg,#4bc6f9 0%,#2db7f0 100%);--dd-radius:.35em;--dd-shadow:0 0 2.5em rgba(0,0,0,0.1);--dd-range:rgba(0,0,0,0.05);--dd-monthBackground:var(--dd-gradient);--dd-monthText:var(--dd-text2);--dd-monthBorder:transparent;--dd-confirmButtonBackground:var(--dd-gradient);--dd-confirmButtonText:var(--dd-text2);--dd-selectedBackground:var(--dd-gradient);--dd-selectedText:var(--dd-text2)}@keyframes dd-rumble{0%,to{transform:translate3d(0,0,0)}10%,30%,50%,70%,90%{transform:translate3d(-2px,0,0)}20%,40%,60%,80%{transform:translate3d(2px,0,0)}}.dd-theme-bootstrap{--dd-background:#f8f9fa;--dd-text1:#212529;--dd-text2:var(--dd-background);--dd-primary:#0d6efd;--dd-primaryBackground:var(--dd-primary);--dd-shadow:0 0 0 1px rgba(0,0,0,0.1),0 0 2.5em rgba(0,0,0,0.1);--dd-range:#0d6efd20;--dd-monthBackground:var(--dd-background);--dd-monthText:var(--dd-text1);--dd-monthBorder:rgba(0,0,0,0.1);--dd-confirmButtonBackground:var(--dd-primaryBackground);--dd-confirmButtonText:var(--dd-text2);--dd-selectedBackground:var(--dd-primaryBackground);--dd-selectedText:var(--dd-text2)}.dd-theme-dark{--dd-background:#2f2f2f;--dd-text1:#ffffff;--dd-text2:#ffffff;--dd-primary:#505050;--dd-range:rgba(0,0,0,0.2)}.dd-rumble{animation:dd-rumble 0.4s ease}.dd-hidden{transition:opacity 0.6s cubic-bezier(0.165,0.84,0.44,1),pointer-events 0.6s cubic-bezier(0.165,0.84,0.44,1),visibility 0.6s cubic-bezier(0.165,0.84,0.44,1),transform 0.6s cubic-bezier(0.165,0.84,0.44,1),width 0.6s cubic-bezier(0.165,0.84,0.44,1),top 0.6s cubic-bezier(0.165,0.84,0.44,1),left 0.6s cubic-bezier(0.165,0.84,0.44,1);opacity:0;pointer-events:none;visibility:hidden;will-change:opacity,visibility,transform}.dd-shown{opacity:1;pointer-events:auto;visibility:visible}.dd-w{color:var(--dd-primary)}.dd__block{position:relative;font-weight:bold;z-index:1;display:flex;align-items:center;justify-content:center}.dd__block[data-key=m]{font-weight:normal;background:var(--dd-monthBackground);color:var(--dd-monthText);border-bottom:1px solid var(--dd-monthBorder);border-top-left-radius:var(--dd-radius);border-top-right-radius:var(--dd-radius)}.dd__block[data-key=m] .dd__view>div{font-size:2em}.dd__block[data-key=d]{border-bottom:1px solid rgba(0,0,0,0.1)}.dd__block[data-key=d] .dd__view{padding:0.75rem 0.35em}.dd__block[data-key=d] .dd__view>div:first-of-type{font-size:5em;line-height:0.65;margin-bottom:0.125em}.dd__block[data-key=d] .dd__view>div:last-of-type{font-size:1.15em}.dd__block[data-key=y] .dd__view>div{font-size:1.5em}.dd__block:hover .dd__nav{opacity:0.5;visibility:visible;pointer-events:auto}.dd__block:hover .dd__nav:hover{opacity:1}.dd__block:hover .dd__view{background-color:rgba(0,0,0,0.05)}.dd__view{padding:0.35em;margin:0.25em;border-radius:0.35em;flex:1;cursor:pointer}.dd__nav{position:absolute;top:50%;transform:translateY(-50%);display:flex;padding:1em;cursor:pointer;width:35%}.dd__nav.dd-left{left:0}.dd__nav.dd-right{right:0;justify-content:flex-end}.dd__nav svg{width:1em;fill:none;fill-rule:evenodd;stroke:currentColor;stroke-width:3px;transition:stroke-width 0.6s cubic-bezier(0.165,0.84,0.44,1);will-change:stroke-width}.dd__nav:hover svg{stroke-width:5px}.dd__primaryButton{width:3.5em;height:3.5em;display:flex;align-items:center;justify-content:center;border-top-left-radius:2em;border-top-right-radius:2em;transition:transform 0.6s cubic-bezier(0.165,0.84,0.44,1);will-change:box-shadow,transform;position:relative;margin:0;outline:0;border-bottom:0;background:var(--dd-confirmButtonBackground);color:var(--dd-confirmButtonText);background-size:150% 150%;background-position:center;overflow:hidden}.dd__primaryButton svg{fill:none;fill-rule:evenodd;stroke:currentColor;stroke-width:3px;transition:stroke-width 0.6s cubic-bezier(0.165,0.84,0.44,1);will-change:stroke-width;color:currentColor;width:2em}.dd__primaryButton:before{content:"";pointer-events:none;position:absolute;top:0;left:0;background-color:black;width:100%;height:100%;transition:opacity 0.6s cubic-bezier(0.165,0.84,0.44,1);opacity:0;z-index:-1}.dd__primaryButton:not([disabled]){cursor:pointer}.dd__primaryButton[disabled]{background:rgba(0,0,0,0.075);color:var(--dd-text1);pointer-events:none}.dd__primaryButton:not([disabled]):hover{transform:translateY(0.35em)}.dd__primaryButton:not([disabled]):hover:before{opacity:0.25}.dd-selecting .dd__calendar div:not(.dd-perEnd) .dd-starting:not(.dd-selected),.dd-selecting .dd__calendar div:not(.dd-perEnd) .dd-starting~.dd__item:not(.dd-selecting~.dd__item):not(.dd-b~.dd__item),.dd-selecting .dd__calendar div:not(.dd-perStart) .dd-starting:not(.dd-selected),.dd-selecting .dd__calendar div:not(.dd-perStart) .dd-starting~.dd__item:not(.dd-selecting~.dd__item):not(.dd-b~.dd__item){background-color:var(--dd-range)}.dd-selecting .dd__calendar div.dd-perEnd .dd-selected~.dd__item,.dd-selecting .dd__calendar div.dd-perStart .dd__item:first-of-type~.dd__item{background-color:var(--dd-range)}.dd__calendar{display:flex;position:relative;border-bottom:1px solid rgba(0,0,0,0.1)}.dd__calendar>div{display:flex;flex-direction:column;transform-origin:top center;padding:0.5rem}.dd__calendar .dd__item{flex:0 0 14.2857142857%;max-width:14.2857142857%;padding:0.5em 0.65em;position:relative}.dd__calendar .dd__item,.dd__calendar .dd__item .dd-value{display:flex;align-items:center;justify-content:center;position:relative}.dd__calendar .dd__item .dd-value{font-size:0.9em}.dd__calendar .dd__item .dd-color{position:absolute;height:0.5rem;width:2rem;opacity:0.25;border-radius:0.35rem;z-index:-1}.dd__calendar .dd__item[data-dd-tooltip]:after{content:attr(data-dd-tooltip);pointer-events:none;position:absolute;box-shadow:0 0 0.5rem rgba(0,0,0,0.1);border-radius:0.35rem;background-color:var(--dd-text1);color:var(--dd-background);padding:0.5rem 1rem;top:100%;left:50%;transform:translateX(-50%) translateY(-0.5rem);z-index:2;opacity:0;visibility:hidden;transition:opacity 0.6s cubic-bezier(0.165,0.84,0.44,1),pointer-events 0.6s cubic-bezier(0.165,0.84,0.44,1),visibility 0.6s cubic-bezier(0.165,0.84,0.44,1),transform 0.6s cubic-bezier(0.165,0.84,0.44,1)}.dd__calendar .dd__item[data-dd-tooltip]:hover:after{transform:translateX(-50%) translateY(0);opacity:1;visibility:visible}.dd__calendar .dd__body,.dd__calendar .dd__header{display:flex;align-items:center;flex-wrap:wrap}.dd__calendar .dd__header{flex-shrink:0;margin-bottom:0.5rem;border-bottom:1px solid rgba(0,0,0,0.1)}.dd__calendar .dd__header>div{opacity:0.5}.dd__calendar .dd__body{flex:1 1 auto}.dd__calendar .dd__body .dd__item{padding:0.65em}.dd__calendar .dd__body .dd__item:before{width:2.75em;height:2.75em;content:"";border-radius:2.75em;position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);border:2px solid transparent}.dd__calendar .dd__body .dd__item.dd-selected{color:var(--dd-selectedText);position:relative;z-index:1}.dd__calendar .dd__body .dd__item.dd-selected:before{background:var(--dd-selectedBackground);background-size:150% 150%;background-position:center}.dd__calendar .dd__body .dd__item.dd-selected .dd-value{transform:scale(1.35);opacity:1}.dd__calendar .dd__body .dd__item.dd-selected.dd-a:before{transform:translate(-50%,-50%) rotate(45deg);border-top-right-radius:0.5em}.dd__calendar .dd__body .dd__item.dd-selected.dd-b:before{transform:translate(-50%,-50%) rotate(-45deg);border-top-left-radius:0.5em}.dd__calendar .dd__body .dd__item:not(.dd-selected).dd-disabled .dd-value{text-decoration:line-through;opacity:0.5}.dd__calendar .dd__body .dd__item:not(.dd-selected):not(.dd-disabled){cursor:pointer}.dd__calendar .dd__body .dd__item:not(.dd-selected):not(.dd-disabled).dd-placeholder .dd-value{opacity:0.5}.dd__calendar .dd__body .dd__item:not(.dd-selected):not(.dd-disabled).dd-point{background-color:var(--dd-range)}.dd__calendar .dd__body .dd__item:not(.dd-selected):not(.dd-disabled):not(.dd-selected).dd-today{text-decoration:underline}.dd__calendar .dd__body .dd__item:not(.dd-selected):not(.dd-disabled):not(.dd-selected).dd-weekend{color:var(--dd-primary)}.dd__calendar .dd__body .dd__item:not(.dd-selected):not(.dd-disabled):not(.dd-selected):hover .dd-value{opacity:1;transform:scale(1.35)}.dd__calendar .dd__body .dd__item:not(.dd-selected):not(.dd-disabled):not(.dd-selected):hover:before{border-color:currentColor;border-style:dashed}.dd__dialog{position:absolute;top:0;left:0;width:100%;height:100%;overflow-y:auto;display:flex;flex-wrap:wrap;align-items:inherit;padding:0.25em;border-radius:var(--dd-radius);background-color:var(--dd-background);z-index:2;transform:translateY(1em)}.dd__dialog .dd__item{flex:0 0 46%;max-width:46%;margin:2%;border-radius:0.35em;padding:1em;font-size:1.25em;font-weight:bold;background-color:rgba(0,0,0,0.05);cursor:pointer;display:flex;align-items:center;justify-content:center;border:1px solid transparent;transform:translateY(1em)}.dd__dialog .dd__item.dd-shown{transform:translateY(0)}.dd__dialog .dd__item:hover{background-color:rgba(0,0,0,0.1)}.dd__dialog.dd-shown{transform:translateY(0)}.dd__expandButton{position:absolute;bottom:0.5em;right:0.5em;width:2.5em;height:2.5em;display:flex;align-items:center;justify-content:center;border-radius:0.35em;background-color:var(--dd-background);box-shadow:0 0 1em rgba(0,0,0,0.15);transition:box-shadow 0.6s cubic-bezier(0.165,0.84,0.44,1),transform 0.6s cubic-bezier(0.165,0.84,0.44,1);cursor:pointer}.dd__expandButton:hover{box-shadow:0 0 0.5em rgba(0,0,0,0.2);transform:scale(0.95)}.dd__expandButton:active{transform:scale(0.9)}.dd__overlay{position:fixed;top:0;left:0;z-index:1;width:100%;height:100%;z-index:2147483646;background-color:var(--dd-overlay)}.dd-preset-onlyMonth .dd__block[data-key=m],.dd-preset-onlyMonth .dd__header,.dd-preset-onlyYear .dd__block[data-key=m],.dd-preset-onlyYear .dd__header{background:var(--dd-background);color:var(--dd-text1)}.dd__dropdown{position:absolute;background-color:var(--dd-background);color:var(--dd-text1);border-radius:var(--dd-radius);box-shadow:var(--dd-shadow);margin:0;padding:0;list-style:none;width:11em;z-index:2147483647;font-size:16px;transform:translateY(-1em) translateX(-50%)}.dd__dropdown,.dd__dropdown *{box-sizing:border-box;-webkit-user-select:none;user-select:none;font-family:"Helvetica Neue",sans-serif;-webkit-tap-highlight-color:transparent;text-align:center;touch-action:manipulation;line-height:1.2}.dd__dropdown>.dd__footer{display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden}.dd__dropdown.dd-shown{transform:translateY(0) translateX(-50%)}@media (max-height:480px),(max-width:480px){.dd__dropdown{position:fixed!important;top:50%!important;left:50%!important;transform:translate(-50%,-50%)!important}}.dd__dropdown:not(.dd-arw-hover) .dd__nav{opacity:0.5;visibility:visible}.dd__dropdown.dd-expanded{width:20em}.dd__dropdown.dd-expanded.dd-doubleView{width:40em}.dd__dropdown.dd-expanded.dd-doubleView .dd-placeholder{opacity:0;visibility:hidden;pointer-events:none}.dd__dropdown.dd-expanded.dd-doubleView .dd__calendar>div{flex:0 0 50%}.dd__dropdown.dd-expanded.dd-doubleView .dd__calendar>div:last-of-type{box-shadow:inset 1px 0 rgba(0,0,0,0.1)}.dd__dropdown.dd-expanded [data-key=d]{display:none}';
    (e.type = "text/css"), e.styleSheet ? (e.styleSheet.cssText = t) : e.appendChild(document.createTextNode(t)), document.head.appendChild(e);
})()