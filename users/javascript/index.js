
var els = $('[gregdate]');
for (var i = 0; i < els.length; i++) {
    var el = els[i];
    var prop = (el.tagName == 'INPUT') ? 'value' : 'innerText';
    var greg = el[prop];
    el[prop] = moment(greg, 'YYYY-MM-DD').add(1,'day').format('iYYYY-iM-iD');
    //NOTE: Moment.js hijri plugin calculates according to avaam date. So adding a day when converting to hijri.
    //In the same way if, we have to convert hijri to greg, we should subtract a day i.e. add -1 day.
}

var els = $('[hijridate]');
for (var i = 0; i < els.length; i++) {
    var el = els[i];
    var prop = (el.tagName == 'INPUT') ? 'value' : 'innerText';
    var greg = el[prop];
    el[prop] = moment(greg, 'iYYYY-iM-iD').format('iD iMMMM iYYYY');
}

//toggle thaali stop/start
$((thaliActive ? '#startThali' : '#stopThali')).hide();    

$((thaliTranport == 'Pick Up') ? '#startTransport' : '#stopTransport').hide();    

