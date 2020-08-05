 <script type="text/javascript">

   function  test()
	   {  
	  qte=document.getElementById('qtee').value;
   window.opener.qte<?php echo $this->params['pass'][0]?>.value = qte; 
   window.opener.calcule();
         //window.opener.nameart.style.display='';
         //window.opener.TicketcaisseArticleId.style.display='none';
         
         window.opener.$("#select").hide();
           //alert("3");
           window.opener.$("#inputcodebarre").show();
           //alert("inputcodebarre");
            window.opener.nameart.focus(); 

 window.close();
	   
	   }
           
          
    </script>
      
    
 <br /><div class="col-md-12">
          
          
           <div class="col-md-6">
                <div class="detailticketdata">
                    <div class="semidetailticketdata">
                        <ul class="ligneticketdata" id="commandlistitems"></ul>
  
<table width="50%" style="padding-left:15px; padding-right:15px; text-align:center" align="center" border="1" cellpadding="2" cellspacing="2"  class="table"><tr><td>Qt&eacute;</td><td>
    <input type="text" class="form-control qtee " style="width:75px; height:35px;  text-align:center" value="<?php echo $this->params['pass'][1]?>"  id="qtee"/></td></tr></table>
      <div align="center"><button    onclick='test()'style="height:55px; width:85px" class=" submitForm   "  id="butonsubmit"data-style="expand-right" data-size="l"  >Valider</button></div>
      
      </div></div></div></div>