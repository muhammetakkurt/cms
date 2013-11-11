<script type="text/javascript" src="//www.google.com/jsapi"></script>
<script type="text/javascript">
  google.load('visualization', '1', {packages: ['corechart']});
</script>
<script type="text/javascript">
  
  /*
  * En çok incelenen ürünler
  */
  function drawtheMostStudiedProducts() {
    // Create and populate the data table.
    var data = google.visualization.arrayToDataTable({{json_encode($theMostStudiedProducts)}});
  	// Create and draw the visualization.

    // Set chart options
    var options = {'title':'En çok incelenen ürünler',
                   'is3D': true,
                   'width':470,
                   'height':300};

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.PieChart(document.getElementById('theMostStudiedProducts'));

    function selectHandler() {
      var selectedItem = chart.getSelection()[0];
      if (selectedItem) {
        var itemId = data.getValue(selectedItem.row, 2);
        location.href="{{URL::to('products')}}/"+itemId+'/edit';
      }
    }

    google.visualization.events.addListener(chart, 'select', selectHandler);    
    chart.draw(data, options);
  }
  
  google.setOnLoadCallback(drawtheMostStudiedProducts);
  /*
  * END
  */


  /*
  * En çok satılan ürünler
  */
  function drawbestSellingProducts() {
    // Create and populate the data table.
    var data = google.visualization.arrayToDataTable({{json_encode($bestSellingProducts)}});
    // Create and draw the visualization.

    // Set chart options
    var options = {'title':'En çok satılan ürünler',
                   'is3D': true,
                   'width':470,
                   'height':300};

    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.PieChart(document.getElementById('bestSellingProducts'));

    function selectHandler() {
      var selectedItem = chart.getSelection()[0];
      if (selectedItem) {
        var itemId = data.getValue(selectedItem.row, 2);
        location.href="{{URL::to('products')}}/"+itemId+'/edit';
      }
    }

    google.visualization.events.addListener(chart, 'select', selectHandler);    
    chart.draw(data, options);
  }
  
  google.setOnLoadCallback(drawbestSellingProducts);
  /*
  * END
  */


  /*
  * En çok puan alan ürünler
  */
  @if(count($topRatedProducts)>1)
    function drawtopRatedProducts() {
      // Create and populate the data table.
      var data = google.visualization.arrayToDataTable({{json_encode($topRatedProducts)}});
      // Create and draw the visualization.

      // Set chart options
      var options = {'title':'En çok puan alan ürünler',
                     'is3D': true,
                     'width':470,
                     'height':300};

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.PieChart(document.getElementById('topRatedProducts'));

      function selectHandler() {
        var selectedItem = chart.getSelection()[0];
        if (selectedItem) {
          var itemId = data.getValue(selectedItem.row, 2);
          location.href="{{URL::to('products')}}/"+itemId+'/edit';
        }
      }

      google.visualization.events.addListener(chart, 'select', selectHandler);    
      chart.draw(data, options);
    }
    
    google.setOnLoadCallback(drawtopRatedProducts);
  @endif
  /*
  * END
  */

  /*
  * En fazla yorum yapılan ürünler
  */
  @if(count($theMostReviewedProducts)>1)
    function drawtheMostReviewedProducts() {
      // Create and populate the data table.
      var data = google.visualization.arrayToDataTable({{json_encode($theMostReviewedProducts)}});
      // Create and draw the visualization.

      // Set chart options
      var options = {'title':'En fazla yorum alan ürünler',
                     'is3D': true,
                     'width':470,
                     'height':300};

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.PieChart(document.getElementById('theMostReviewedProducts'));

      function selectHandler() {
        var selectedItem = chart.getSelection()[0];
        if (selectedItem) {
          var itemId = data.getValue(selectedItem.row, 2);
          location.href="{{URL::to('product-reviews')}}/"+itemId+'/edit';
        }
      }

      google.visualization.events.addListener(chart, 'select', selectHandler);    
      
      chart.draw(data, options);
    }
    
    google.setOnLoadCallback(drawtheMostReviewedProducts);
  @endif
  /*
  * END
  */

  /*
  * Hiç satılamayan ürünler
  */
  @if(count($unsoldProducts)>1)
    function drawunsoldProducts() {
      // Create and populate the data table.
      var data = google.visualization.arrayToDataTable({{json_encode($unsoldProducts)}});
      // Create and draw the visualization.

      // Set chart options
      var options = {'title':'Hiç satılmayan ürünler',
                     'is3D': true,
                     'width':470,
                     'height':300};

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.PieChart(document.getElementById('unsoldProducts'));

      function selectHandler() {
        var selectedItem = chart.getSelection()[0];
        if (selectedItem) {
          var itemId = data.getValue(selectedItem.row, 2);
          location.href="{{URL::to('products')}}/"+itemId+'/edit';
        }
      }

      google.visualization.events.addListener(chart, 'select', selectHandler);    
      
      chart.draw(data, options);
    }
    
    google.setOnLoadCallback(drawunsoldProducts);
  @endif
  /*
  *  END 
  */

  /*
  * En fazla alış-veriş yapan üyeler
  */
  @if(count($mostShoppers)>1)
    function drawmostShoppers() {
      // Create and populate the data table.
      var data = google.visualization.arrayToDataTable({{json_encode($mostShoppers)}});
      // Create and draw the visualization.

      // Set chart options
      var options = {'title':'En çok alışveriş yapan üyeler',
                     'is3D': true,
                     'width':470,
                     'height':300};

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.PieChart(document.getElementById('mostShoppers'));

      function selectHandler() {
        var selectedItem = chart.getSelection()[0];
        if (selectedItem) {
          var itemId = data.getValue(selectedItem.row, 2);
          location.href="{{URL::to('users')}}/"+itemId;
        }
      }

      google.visualization.events.addListener(chart, 'select', selectHandler);    
      chart.draw(data, options);
    }
    
    google.setOnLoadCallback(drawmostShoppers);
  @endif
  /*
  * END
  */

  /*
  * En fazla alış-veriş yapan üyeler
  */
  @if(count($theMostReviewedArticles)>1)
    function drawtheMostReviewedArticles() {
      // Create and populate the data table.
      var data = google.visualization.arrayToDataTable({{json_encode($theMostReviewedArticles)}});
      // Create and draw the visualization.

      // Set chart options
      var options = {'title':'En çok yorum yapılan makaleler',
                     'is3D': true,
                     'width':470,
                     'height':300};

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.PieChart(document.getElementById('theMostReviewedArticles'));

      function selectHandler() {
        var selectedItem = chart.getSelection()[0];
        if (selectedItem) {
          var itemId = data.getValue(selectedItem.row, 2);
          location.href="{{URL::to('cms-articles')}}/"+itemId+"/edit";
        }
      }

      google.visualization.events.addListener(chart, 'select', selectHandler);    
      chart.draw(data, options);
    }
    
    google.setOnLoadCallback(drawtheMostReviewedArticles);
  @endif
  /*
  * END
  */

</script>