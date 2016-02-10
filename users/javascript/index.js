
var els = $('.gregdate');
for (var i = 0; i < els.length; i++) {
    var el = els[i];
    var prop = (el.tagName == 'INPUT') ? 'value' : 'innerText';
    var greg = el[prop];
    var hijri = HijriDate.fromGregorian(new Date(greg));
    el[prop] =  hijri.year + '-' + ((+hijri.month) + (+1)) + '-' + hijri.day;
    el[prop] =  moment(el[prop], 'YYYY-MM-DD').format('YYYY-MM-DD');
}

var els = $('.hijridate');
for (var i = 0; i < els.length; i++) {
    var el = els[i];
    var prop = (el.tagName == 'INPUT') ? 'value' : 'innerText';
    var hijri = el[prop];
    el[prop] = moment(hijri, 'iYYYY-iM-iD').format('iD iMMMM iYYYY');
}