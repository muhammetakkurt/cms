$('#searchForm').submit(function(e){
  var minLength = 3;
  if($('#search').val().length < minLength)
  {
    e.preventDefault();
    e.stopPropagation();
    $('#required-control div').html("Arama yapabilmek için en az " + minLength + " karakter girmelisiniz.");
    $('#required-control').fadeIn();
    return false;
  }
});
$('#search').typeahead({
    source: function(query, process) {
        objects = [];
        map = {};
        return $.getJSON('{{URL::to("ajax/active-products-search")}}', {query: query}, function (data) {
        console.log(data);
            $.each(data, function(i, object) {
            map[(object.type=='1' ? 

            '<img src="{{ Request::root() }}' + '/assets/thumbnail.php?src=' + object.default_image_filename_path + '&w=70&h=55&zc=1"> ' : '<img src="{{ Request::root() }}' + '/assets/thumbnail.php?src=' + object.default_image_filename_path + '&w=70&h=55&zc=1"> ')+object.name] = object;
            objects.push((object.type=='1' ? 
            '<img src="{{ Request::root() }}' + '/assets/thumbnail.php?src=' + object.default_image_filename_path + '&w=70&h=55&zc=1"> ' : '<img src="{{ Request::root() }}' + '/assets/thumbnail.php?src=' + object.default_image_filename_path + '&w=70&h=55&zc=1"> ')+object.name);
          });
          process(objects);
          console.log(map);
        });

    },
    highlighter: function (item) {
      return item;
    },
    updater: function(item) {
    
      if(map[item].type==1)
      {
        location.href='{{URL::to('product')}}/'+map[item].seo_name+'?query='+$('#search').val();
      }
      else
      {
        location.href='{{URL::to('category')}}/'+map[item].seo_name+'?query='+$('#search').val();
      }
      
    },
    
    minLength: 3
});