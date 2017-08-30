{include file="tpl/admin/header.tpl"}

<div id="wrapper">
   <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="adjust-nav">
         <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">
                <img src="/admin/raw/logo" />
            </a>
         </div>
      </div>
   </div>
   <!-- /. NAV TOP  -->
   {if isset($_menu_)}
       <nav class="navbar-default navbar-side" role="navigation">
          <div class="sidebar-collapse">
             <ul class="nav" id="main-menu">
                {include file="tpl/admin/menu.tpl"}
             </ul>
          </div>
       </nav>
   {else}
       <nav class="navbar-default navbar-side" role="navigation">
          <div class="sidebar-collapse">
             <ul class="nav" id="main-menu">
                <li><a href="/admin"><i class="fa fa-desktop "></i>Start</a></li>
             </ul>
          </div>
       </nav>
   {/if} 
   <!-- /. NAV SIDE  -->
   <div id="page-wrapper" >
      <div id="page-inner">
         <div class="row">
            <div class="col-md-12">
               {if isset($ComponentTpl)}
               {include file=$ComponentTpl}
               {/if}
            </div>
         </div>
         <!-- /. ROW  -->
         <hr />
         <!-- /. ROW  -->           
      </div>
      <!-- /. PAGE INNER  -->
   </div>
   <!-- /. PAGE WRAPPER  -->
</div>

{if isset($debug) && $debug == true}
    {include file='../sys/debug.tpl'}
{/if}

{include file="tpl/admin/footer.tpl"}