// After the API loads, call a function to enable the search box.
function handleAPILoaded() {
  $('#search-button').attr('disabled', false);
}

// Search for a specified string.
function search() {
  var q = $('#query').val();
  var request = gapi.client.youtube.search.list({
    q: q,
    part: 'snippet'
  });

  request.execute(function(response) {
    var str = JSON.stringify(response.result);
    $('#search-container').html('<pre>' + str + '</pre>');
  });
}
/*
<!doctype html>
<html>
  <head>
    <title>Search</title>
  </head>
  <body>
    <div id="buttons">
      <label> <input id="query" value='cats' type="text"/><button id="search-button" disabled onclick="search()">Search</button></label>
    </div>
    <div id="search-container">
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="auth.js"></script>
    <script src="search.js"></script>
    <script src="https://apis.google.com/js/client.js?onload=googleApiClientReady"></script>
  </body>
</html>
*/