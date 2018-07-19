$().ready( function () {
          // ajax-> jangan diletakkan di paling bawah tapi paling atas dari jquery yang lain
          $("#jab").change(function(){
            var jabs = $("#jab").val();            
            $.ajax({
              url: "mod_sistem/md_adminkop/action/ajax.php",
              data: "idjab=" + jabs,  // ingat nilai variabel GET gak boleh ada spasi antara variable get dengan '='
              success: function(data){
                $("#submenu").html(data);
                // alert(data);
              }
            })
          });

          $('#jabatan').change(function(){
            var a = $('#jabatan').val();
            $.ajax({
              url: "mod_sistem/md_adminkop/action/ajax.php",
              data: "j=" + a,
              success: function(data){
                $("#menu").html(data);
              }
            })
          });

          $('#jab-ren').change(function(){
            var j = $('#jab-ren').val();
            $.ajax({
              url: "mod_sistem/md_b.kumkm/ajax.php",
              data: "jb_pj="+j,
              success: function(data){
                $('#peg').html(data);
              }
            });
          });
          

          $('#id_siap').change(function(){
            var siap = $('#id_siap').val();
            $.ajax({
              url: "mod_sistem/md_b.kumkm/ajax.php",
              data: "siap="+siap,
              success: function(oye){
                $('#nm_sub').html(oye); 
              }
            });
          });

          $('#id_pelak').change(function(){
            var p = $('#id_pelak').val();
            $.ajax({
              url: "mod_sistem/md_b.kumkm/ajax.php",
              data: "pelak="+p,
              success: function(woy){
                $('#nm_sub').html(woy); 
              }
            });
          });



          $("#lala1").change(function(){
            $('#lala2').html("<img src='../global/img/ajax-loader.gif' /> proses ...");  
            var idkegiatan  = $("#lala1").val();           
            $.ajax({
             type:"POST",
             url:"mod_sistem/md_b.kumkm/cek_id.php",    
             data: "id=" + idkegiatan,
             success: function(data){                 
               if(data==0){
                  $("#lala2").html('<span class="tebal tersedia">Okey, kode bisa digunakan</span>');
                  $('#lala1').css('border', '3px #090 solid'); 
               }  
               else{
                  $("#lala2").html('<span class="tebal tidak_tersedia">Kode sudah ada di Database</span>');       
                  $('#lala1').css('border', '3px #C33 solid'); 
               }
             }
            }); 
        });

          $("#kdpenyi1").change(function(){
            // karena js maka acuannya untuk pengalamatan gambar/file adalah pemanggilnya
            $('#kdpenyi2').html("<img src='../global/img/ajax-loader.gif' /> proses ...");  
            var idkegiatan  = $("#kdpenyi1").val();   
            $.ajax({
             type:"POST",
             url:"mod_sistem/md_b.kumkm/cek_id.php",    
             data: "kdpenyi=" + idkegiatan,
             success: function(data){
               if(data==0){
                  $("#kdpenyi2").html('<span class="tebal tersedia">Okey, kode bisa digunakan</span>');
                  $('#kdpenyi1').css('border', '3px #090 solid'); 
               }  
               else{
                  $("#kdpenyi2").html('<span class="tebal tidak_tersedia">Kode sudah ada di Database</span>');       
                  $('#kdpenyi1').css('border', '3px #C33 solid'); 
               }
             }
            }); 
        });


          //validasi nomor pelaksanaan
          $("#no_laksana").change(function(){
            // karena js maka acuannya untuk pengalamatan gambar/file adalah pemanggilnya
            $('#alert_laksana').html("<img src='../global/img/ajax-loader.gif' /> proses ...");  
            var idlaksana  = $("#no_laksana").val();   
            $.ajax({
             type:"POST",
             url:"mod_sistem/md_b.kumkm/cek_id.php",    
             data: "kdlaksana=" + idlaksana,
             success: function(data){
               if(data==0){
                  $("#alert_laksana").html('<span class="tebal tersedia">Okey, kode bisa digunakan</span>');
                  $('#no_laksana').css('border', '3px #090 solid'); 
               }  
               else{
                  $("#alert_laksana").html('<span class="tebal tidak_tersedia">Kode sudah ada di Database</span>');       
                  $('#no_laksana').css('border', '3px #C33 solid'); 
               }
             }
            }); 
        });

          //cek nomor pengawasan
          //validasi nomor pelaksanaan
          $("#no_penga").change(function(){
            // karena js maka acuannya untuk pengalamatan gambar/file adalah pemanggilnya
            $('#cek_penga').html("<img src='../global/img/ajax-loader.gif' /> proses ...");  
            var i  = $("#no_penga").val();   
            $.ajax({
             type:"POST",
             url:"mod_sistem/md_b.kumkm/cek_id.php",    
             data: "kdpenga=" + i,
             success: function(data){
               if(data==0){
                  $("#cek_penga").html('<span class="tebal tersedia">Okey, kode bisa digunakan</span>');
                  $('#no_penga').css('border', '3px #090 solid'); 
               }  
               else{
                  $("#cek_penga").html('<span class="tebal tidak_tersedia">Kode sudah ada di Database</span>');       
                  $('#no_penga').css('border', '3px #C33 solid'); 
               }
             }
            }); 
        });

          //ALERT untuk LINK MODUL TIDAK BOLEH SAMA
          $("#link").change(function(){
            // karena js maka acuannya untuk pengalamatan gambar/file adalah pemanggilnya
            $('#alert_link').html("<img src='../global/img/ajax-loader.gif' /> proses ...");  
            var i  = $("#link").val();   
            $.ajax({
             type:"POST",
             url:"mod_sistem/md_adminkop/cek_ajax.php",    
             data: "mdlink=" + i,
             success: function(data){
               if(data==0){
                  $("#alert_link").html('<span class="tebal tersedia">Okey, URL bisa digunakan</span>');
                  $('#link').css('border', '3px #090 solid'); 
               }  
               else{
                  $("#alert_link").html('<span class="tebal tidak_tersedia">URL sudah ada di Database</span>');       
                  $('#link').css('border', '3px #C33 solid'); 
               }
             }
            }); 
        });

          // informasi biru ---------------------------

          // informasi perencanaan di penyiapan
        $("#nama_peren").change(function(){            
            $('#info_peren').html("<img src='../global/img/ajax-loader.gif' /> proses ...");  
            var p  = $("#nama_peren").val();   
            $.ajax({
             type:"POST",
             url:"mod_sistem/md_b.kumkm/cek_id.php",    
             data: "idperen="+p,
             success: function(data){
              $("#info_peren").html(data);
             }
            }); 
        });

          //info penyiapan di form pelaksanaan
          $("#id_siap").change(function(){            
            $('#info_penyi').html("<img src='../global/img/ajax-loader.gif' /> proses ...");  
            var s  = $("#id_siap").val();               
            // alert(s);
            $.ajax({
             type:"POST",
             url:"mod_sistem/md_b.kumkm/cek_id.php",    
             data: "idpenyi="+s,
             success: function(data){
              $("#info_penyi").html(data);
             }
            }); 
        });

          //info pelaksanaan di form pengawasan

          $("#id_pelak").change(function(){            
            $('#info_pelak').html("<img src='../global/img/ajax-loader.gif' /> proses ...");  
            var s  = $("#id_pelak").val();               
            // alert(s);
            $.ajax({
             type:"POST",
             url:"mod_sistem/md_b.kumkm/cek_id.php",    
             data: "idpelak="+s,
             success: function(data){
              $("#info_pelak").html(data);
             }
            }); 
        });

          





        $("#tah").change(function(){
          var y = $("#tah").val();
          $('#alias').val(y);
        });

          //set value input sama dengan value combobox
          $('#kp').change(function(){
            var t = $('#kp').val();
            $('#idren').val(t);            
          });  

          

        //  INPUTAN NDETEK DIGIT NUMBER FOR MONEY
          $('input#ang').keyup(function(event) {
          // skip for arrow keys
          if(event.which >= 37 && event.which <= 40){ //37,38,39,40
            event.preventDefault();
          }
          $(this).val(function(index, value) {
            return value
              .replace(/\D/g, "")
              .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            ;
          });
        });

        
          

          $('#tabelscroll_x').dataTable({
            "sScrollX": "100%",
            "sScrollXInner": "110%",
            "bScrollCollapse": true,
            "sPaginationType": "full_numbers"
          });

          $('#table_id_scroll').dataTable({
            "sScrollY": 400,            
            "sPaginationType": "full_numbers"
          });
          
          $('#table_id').dataTable({
            "sScrollY": 400,
            "sPaginationType": "full_numbers"
          });

          $(".doc").popover();
          $(".des").popover();
          $('.tool').popover({

          });
          $('.hitam').tooltip();
          $('#timepicker').timepicker();
          $('input[type=file]').bootstrapFileInput(); 
          $(".alert-autoclose").alert(); 
                   
          window.setTimeout(function() {
            $(".alert-autoclose").fadeTo(500, 0).slideUp(500, function(){
              $(this).remove(); 
              });
          }, 5000);

          $("#upload").hide(); 
          $("#info_upload").hide();


          $('#datemulai').datepicker();
          $('#dateselesai').datepicker();
          $('#tglmulai').datepicker();
          $('#tglselesai').datepicker();



        // tanggal range + validasi

      // var a = new Date();
      // var tgl = a.getDate();
      // var bln = a.getMonth();
      // var thn = a.getYear();

      // var startDate = new Date(2013,10,20);
      // // var startDate = tgl+"-"+bln+"-"+thn;
      // var endDate = new Date(2013,10,25);

      // $('#datemulai').datepicker()
      //   .on('changeDate', function(ev){
      //     if (ev.date.valueOf() > endDate.valueOf()){
      //       $('#alert').show().find('strong').text('Maaf, Tanggal mulai tidak boleh lebih besar dari Tanggal Selesai');
      //     } else {
      //       $('#alert').hide();
      //       startDate = new Date(ev.date);            
      //     }          
      //   });

      // $('#dateselesai').datepicker()
      //   .on('changeDate', function(ev){
      //     if (ev.date.valueOf() < startDate.valueOf()){
      //       $('#alert').show().find('strong').text('Maaf, Tanggal Selesai tidak boleh lebih kecil dari Tanggal Mulai');
      //     } else {
      //       $('#alert').hide();
      //       endDate = new Date(ev.date);            
      //     }          
      //   });


      //   var start = new Date(2013,10,20);      
      //   var end = new Date(2013,10,25);
      //   // for second
      //   $('#tglmulai').datepicker()
      //   .on('changeDate', function(ev){
      //     if (ev.date.valueOf() > end.valueOf()){
      //       $('#alerterror').show().find('strong').text('Maaf, Tanggal mulai tidak boleh lebih besar dari Tanggal Selesai');
      //     } else {
      //       $('#alerterror').hide(); 
      //       start = new Date(ev.date);
      //     }          
      //   });

      // $('#tglselesai').datepicker()
      //   .on('changeDate', function(ev){
      //     if (ev.date.valueOf() < start.valueOf()){
      //       $('#alerterror').show().find('strong').text('Maaf, Tanggal Selesai tidak boleh lebih kecil dari Tanggal Mulai');
      //     } else {
      //       $('#alerterror').hide();
      //       end = new Date(ev.date);
      //     }          
      // });


} );

// hide dan show checkbox
function tampilkan_cek(){
        if($('#upload_cek').is(':checked')){
          $('#upload').show();
          $('#info_upload').show();
        }else{
          $('#upload').hide();
          $('#info_upload').hide();
        }
    }

function rubah_link(){
        if($('#rubah').is(':checked')){
          $('#rubah1').show();
          $('#rubah2').show();
        }else{
          $('#rubah1').hide();
          $('#rubah2').hide();
        }
    }

function ganti_th(b, r){
  var t = $(b).val();
  //alert(t);
  if(t==0){
    $(r).attr({"disabled": true});
    // css({"border-color":"red"})
  }else{
    $(r).attr("disabled", false);
    $.getJSON("mod_sistem/md_b.kumkm/ajax.php?th="+t,
    function (oke){      
      $(r).html(oke);
    });
  
  }
}

function func_kegiatan(hh,jj){
  var m = $(hh).val();
  //alert(m);
  if(m==0){
    $(jj).attr({"disabled": true});
  }else{
    $(jj).attr({"disabled": false});
    $.getJSON("mod_sistem/md_b.kumkm/ajax.php?keg="+m,
      function (has){
        $(jj).html(has);
      }
      )
  }
}

function func_bulan(oy, keg, tah_lap){
  var a1 = $(oy).val();
  var idlap = $(keg).val();  
  if(a1==0){
    $(tah_lap).attr({"disabled": true});
  }else{
    $(tah_lap).attr({"disabled": false});    
    $.getJSON("mod_sistem/md_b.kumkm/ajax.php?idbul="+a1+"&idkeg="+idlap,
      function (yoi){
        //alert(a1);
        $(tah_lap).html(yoi);
      }
    )
  } 
}

//getdata untuk evaluasi
function ganti_bulan_eval(a1,b1,c1){
  var bulanren = $(a1).val(), tahunren = $(b1).val();
  // alert(bulanren+" - "+tahunren);
  $.getJSON("mod_sistem/md_b.kumkm/ajax.php?x="+bulanren+"&y="+tahunren,
    function (resulte){
      $(c1+" tbody").html(resulte);
    }
    )
}


function ganti_bulan(a, b, tabel){
  var bln = $(a).val(), 
      thn = $(b).val();

  //alert(bln);
  $.getJSON("mod_sistem/md_b.kumkm/ajax.php?a="+bln+"&b="+thn, 
    function (hasil){
      // $(tabel+" thead th").eq(4).html(hasil);
      // var ht = $(tabel+" thead th:eq(4)").html();
      // ht += " - "+bln;
      // $(tabel+" thead th:eq(4)").html(ht);
      // $(tabel+" thead").find("th").eq(4).html(hasil);
      $(tabel+" tbody").html(hasil);
    });
}

function ganti_th_pelak(a,b){
  var j = $(a).val();
  // alert(j);
  if(j==0){
    $(b).attr("disabled", true);
  }else{
    $(b).attr("disabled", false);
    $.getJSON("mod_sistem/md_b.kumkm/ajax.php?h="+j, 
      function (oke){
        $(b).html(oke);
      });
  }
}



function ganti_bidang(x,y){
  var idbidang = $(x).val();
  // alert(idbidang);
  if(idbidang==0){
    $(y).attr("disabled", true);
  }else{
    $(y).attr("disabled", false);
    $.getJSON("mod_sistem/md_b.kumkm/ajax.php?bid="+idbidang,
      function (tampil_seksi){
        $(y).html(tampil_seksi);
      }
      );
  }
}

function ganti_seksi(q,w,e){
  var idsek = $(q).val(), idtahun = $(w).val();
  // alert(idsek+" - "+idtahun);
  $.getJSON("mod_sistem/md_b.kumkm/ajax.php?ids="+idsek+"&idb="+idtahun, 
    function (result){      
      $(e).html(result);
    });
}

function ganti_seksi_bid(idsek, info){
  var seks = $(idsek).val();
  // alert(n);
  $.getJSON("mod_sistem/md_b.kumkm/ajax.php?idseks="+seks, 
    function (result){      
      $(info).html(result);
    });

}

function ganti_bl_pelak(bl,th,tbl){
  var bln = $(bl).val(), thn = $(th).val();
  // alert(thn);
  $.getJSON("mod_sistem/md_b.kumkm/ajax.php?bulan="+bln+"&tahun="+thn, 
    function (result){      
      $(tbl+" tbody").html(result);
    });
}

function validation(sender, required)
{
  var obj = $(sender).find("."+required);
  var hit=0;
  for(var i=0; i<obj.length; i++)
  {
    if(obj.eq(i).val() == "")
    {      
      obj.eq(i).css('border', "2px solid red");
      hit++;
    }
  }

  var jab = $(sender).find("select#jab-ren").val();
  var peg = $(sender).find("select#peg").val();
  if(jab == 0){
    $("select#jab-ren").css('border', "2px solid red");   
    hit++;
  }

  if(peg == 0){
    $("select#peg").css('border', "2px solid red");    
    hit++;
  }

  if(hit !=0 ){return false;}
  // var 
  return true;
}

function cek_error(obj){
  var border = $(obj).attr("style").search("border");
  if(border != -1){
    $(obj).removeAttr("style");
  }
}












      