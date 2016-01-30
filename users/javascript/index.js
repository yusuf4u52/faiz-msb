
var els = $('.gregdate');
for (var i = 0; i < els.length; i++) {
    var el = els[i];
    var prop = (el.tagName == 'INPUT') ? 'value' : 'innerText';
    var greg = el[prop];
    el[prop] = moment(greg, 'YYYY-MM-DD').add(1,'day').format('iYYYY-iM-iD');
}

var els = $('.hijridate');
for (var i = 0; i < els.length; i++) {
    var el = els[i];
    var prop = (el.tagName == 'INPUT') ? 'value' : 'innerText';
    console.log(prop);
    var greg = el[prop];
    el[prop] = moment(greg, 'iYYYY-iM-iD').format('iD iMMMM iYYYY');
}