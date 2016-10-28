(function(){
var 
 form = $('.front'),
 // cache_width = form.width(),
 a4  =[ 595.28,  841.89];  // for a4 size paper width and height
 
$('#download_pdf').on('click',function(){
 $('body').scrollTop(0);
 createPDF();
});
//create pdf
function createPDF(){
 getCanvas().then(function(canvas){
  var 
  img = canvas.toDataURL("image/png"),
  doc = new jsPDF({
          unit:'px', 
          format:'a4'
        });
        doc.addImage(img, 'JPEG', 30, 30, 400, 580 );
        
        doc.save('alumnify-analytics.pdf');
        // form.width(cache_width);
 });
}
 
// create canvas object
function getCanvas(){
 // form.width();
 screenshot = html2canvas(form, {
  onrendered: function(canvas) {
    
  }
  });

 return screenshot;
}
 
}());