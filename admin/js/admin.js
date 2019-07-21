$(document).on("click", '.toggle', function(e) {
    // $('.toggle').click(function(e) {
    e.preventDefault();

    var $this = $(this);
    console.log($this);
    
    if ($this.parent().parent().next().hasClass('show')) {
        $this.html('View Details');
        $this.parent().parent().next().removeClass('show');
        $this.parent().parent().next().slideUp(0);
    } else {
        $this.html('Hide Details');
        $this.parent().parent().next().removeClass('hide');
        $this.parent().parent().next().slideUp(0);
        $this.parent().parent().next().toggleClass('show');
        $this.parent().parent().next().slideToggle(0);
    }
    // });
    var init = function(){
        var isMobile = navigator.userAgent &&
          navigator.userAgent.toLowerCase().indexOf('mobile') >= 0;
        var isSmall = window.innerWidth < 1000;
        
        var ps = new ParticleSlider({
          ptlGap: isMobile || isSmall ? 3 : 0,
          ptlSize: isMobile || isSmall ? 3 : 1,
          width: 1e9,
          height: 1e9
        });

        var gui = new dat.GUI();
        gui.add(ps, 'ptlGap').min(0).max(5).step(1).onChange(function(){
          ps.init(true);
        });
        gui.add(ps, 'ptlSize').min(1).max(5).step(1).onChange(function(){
          ps.init(true);
        });
        gui.add(ps, 'restless');
        gui.addColor(ps, 'color').onChange(function(value){
          ps.monochrome = true;
          ps.setColor(value);
            ps.init(true);
        });
        
        
    (window.addEventListener
        ? window.addEventListener('click', function(){ps.init(true)}, false)
        : window.onclick = function(){ps.init(true)});
    }
      
    var initParticleSlider = function(){
    var psScript = document.createElement('script');
    (psScript.addEventListener
        ? psScript.addEventListener('load', init, false)
        : psScript.onload = init);
    psScript.src = 'https://s3-us-west-2.amazonaws.com/s.cdpn.io/23500/ps-0.9.js';
        psScript.setAttribute('type', 'text/javascript');
    document.body.appendChild(psScript);
    }
    
    (window.addEventListener
    ? window.addEventListener('load', initParticleSlider, false)
    : window.onload = initParticleSlider);
});

