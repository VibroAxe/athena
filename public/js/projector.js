var slideID = -1
var ajaxTimer;
var currentiFrame = 1;
var currentSlideFrame = $('#slideFrame' + currentiFrame);
var currentSlideDiv = $('#slideDiv' + currentiFrame);
var nextSlideFrame = $('#slideFrame' + currentiFrame);
var nextSlideDiv = $('#slideDiv' + currentiFrame);

$(document).ready(function () {
    //ajaxTimer = setTimeout(refreshAjax, 2000);
    refreshAjax();
});

function refreshAjax() {
    var slideFrame = $('#slideFrame');
    $.getJSON('/api/projector', slideDataLoad);
    //sbData.text('Loading the JSON file.');
    //If we have just run, clear any pending updates and start again. Allows us to call refreshAjax directly
    clearInterval(ajaxTimer);
    //Use the default timeout for now
    ajaxTimer = setTimeout(refreshAjax, 60000);
}

function slideDataLoad(data) {

    console.log(data);

    var fadeDelay = 1500;

    currentSlideFrame = $('#slideFrame' + currentiFrame);
    currentSlideDiv = $('#slideDiv' + currentiFrame);
    if (currentiFrame == 2) {
        currentiFrame = 1;
    } else {
        currentiFrame = 2;
    }
    nextSlideFrame = $('#slideFrame' + currentiFrame);
    nextSlideDiv = $('#slideDiv' + currentiFrame);

    //find the next slideID based on current slideid
    data = data.data;
    dataLength = data.length;    
    foundIndex=-1;
    for(var i=0; i<dataLength; i++) {
      if (foundIndex == -1) {
        if (data[i].id == slideID)  {
          foundIndex = i;;
        }
      } else {
        if (data[i].published == 1) {
          //Data is published
          //is it within date range
          if (true) {
            foundIndex = i;
            break;
          }
        }
      }
    }

    if (foundIndex == -1 || data[foundIndex].id == slideID) {
      for (var i=0; i<dataLength; i++) {
        if (data[i].published == 1) {
          //data is published
          //is it within date range
          if (true) {
            foundIndex=i;
            break;
          }
        }
      }
    }
    if (foundIndex >= 0) {
      slideID = data[foundIndex].id;
      slideUrl = decodeURI(data[foundIndex].url);
      slideTimespan = data[foundIndex].timespan*1000;
    } else {
      slideID = -1;
      slideUrl = 'about:blank';
      slideTimespan = 30;
    }

    clearInterval(ajaxTimer);
    ajaxTimer = setTimeout(refreshAjax, slideTimespan);
    if (slideTimespan < fadeDelay) {
        fadeDelay = data.TimeSpan / 4;
        if (fadeDelay < 500) {
            fadeDelay = 500;
        }
    }

    if (nextSlideFrame.attr('src') != slideUrl) {
        nextSlideFrame.attr('src', slideUrl);
    }

    //nextSlideDiv.fadeIn(fadeDelay);
    //currentSlideDiv.fadeOut(fadeDelay);
    //nextSlideDiv.show();
    //currentSlideDiv.hide();
    
    /*setTimeout(fadeDelay, function () {
        currentSlideFrame.attr('src', '');
    });*/


}

function switchFrames() {
    //nextSlideDiv.fadeIn(fadeDelay);
    //currentSlideDiv.fadeOut(fadeDelay);
    nextSlideDiv.show();
    currentSlideDiv.hide(); 
}

