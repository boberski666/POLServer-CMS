<script type="text/javascript">
{literal} 
    var elems = document.getElementsByClassName('confirmation');
    var confirmIt = function (e) {
        if (!confirm('Jesteś pewien, że chcesz wykonać wybraną operację?')) e.preventDefault();
    };
    for (var i = 0, l = elems.length; i < l; i++) {
        elems[i].addEventListener('click', confirmIt, false);
    }
{/literal}

</script>
</BODY>
</HTML>
