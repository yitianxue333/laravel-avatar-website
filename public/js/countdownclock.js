/*===============================

Countdown. 
Based on Kerem Suer dribble shot:
http://dribbble.com/shots/560534

change value of the variable --countTo-- to set the timer.
Would love to see someone adding a UI to this one.

=================================*/

 

(function drawCanvas(){
  var canvas=document.getElementById('mycanvas');
  var ctx=canvas.getContext('2d');

  var canvasclock =document.getElementById('showclock');
  var ctxclock = canvasclock.getContext('2d');

  var cWidth=canvas.width;
  var cHeight=canvas.height;

  var countTo=5400;
  var seconds = 86400;

  var hour= Math.floor(countTo/3600);
  var min=Math.floor((countTo-hour*3600)/60);
  var sec=countTo-(min*60)-(hour*3600);
  var counter=0;
  var angle=270;



  var inc=360/seconds; 
  
  var clockangle =(countTo/seconds)*360;
  var startangle = clockangle-inc*1000;
  var endangle = clockangle+inc*1000;

  var startinangle =clockangle-inc*500;
  var endinangle =clockangle+inc*500;

      stylesDeg = [
          "@-webkit-keyframes rotate-hour{from{transform:rotate(" + 0 + "deg);}to{transform:rotate(" + (clockangle ) + "deg);}}",
          "@-moz-keyframes rotate-hour{from{transform:rotate(" + 0 + "deg);}to{transform:rotate(" + (clockangle ) + "deg);}}",
      ].join("");

  document.getElementById("counter").innerHTML = stylesDeg;
  

  function drawScreen() {
    
    
    
    //======= reset canvas
    
    ctx.fillStyle="#fff";
    ctx.fillRect(0,0,cWidth,cHeight);
    
    ctxclock.fillStyle="#fff";
    ctxclock.fillRect(0,0,cWidth,cHeight);
    //========== base arc
    
    ctx.beginPath();
    ctx.strokeStyle="#0072bb";
    ctx.lineWidth=14;
    ctx.arc(cWidth/2,cHeight/2,100,(Math.PI/180)*0,(Math.PI/180)*360,false);
    ctx.stroke();
    ctx.closePath();
    

    //==========     alarm clock==========//

    ctx.beginPath();
    ctx.strokeStyle="#0072bb";
    ctx.lineWidth=5;
    ctx.arc(cWidth/2,cHeight/2,5,(Math.PI/180)*0,(Math.PI/180)*360,false);
    ctx.stroke();
    ctx.closePath();



    ctx.beginPath();
    ctx.strokeStyle="#0072bb";
    ctx.lineWidth=6;
    ctx.arc(cWidth/2,cHeight/2,119,(270/360)*Math.PI*2+(startangle/360)*Math.PI*2,(270/360)*Math.PI*2+(endangle/360)*Math.PI*2,false);
    ctx.stroke();
    ctx.closePath();

    ctx.beginPath();
    ctx.strokeStyle="#0072bb";
    ctx.lineWidth=6;
    ctx.arc(cWidth/2,cHeight/2,119,(Math.PI/180)*270-(Math.PI/180)*inc*500,(Math.PI/180)*270+(Math.PI/180)*inc*500,false);
    ctx.stroke();
    ctx.closePath();

    ctx.beginPath();
    ctx.strokeStyle="#0072bb";
    ctx.lineWidth=5;
    ctx.arc(cWidth/2,cHeight/2,114,(270/360)*Math.PI*2+(startinangle/360)*Math.PI*2,(270/360)*Math.PI*2+(endinangle/360)*Math.PI*2,false);

    ctx.stroke();
    ctx.closePath();

    ctx.beginPath();
    ctx.strokeStyle="#0072bb";
    ctx.lineWidth=5;
    ctx.arc(cWidth/2,cHeight/2,114,(Math.PI/180)*270-(Math.PI/180)*inc*500,(Math.PI/180)*270+(Math.PI/180)*inc*500,false);

    ctx.stroke();
    ctx.closePath();
    //========== dynamic arc
    
    ctx.beginPath();
    ctx.strokeStyle="#0072bb";
    ctx.lineWidth=14;
    ctx.arc(cWidth/2,cHeight/2,100,(Math.PI/180)*270,(Math.PI/180)*angle,false);
    ctx.stroke();
    ctx.closePath();
    
    //======== inner shadow arc
    
    grad=ctx.createRadialGradient(cWidth/2,cHeight/2,80,cWidth/2,cHeight/2,115);
    grad.addColorStop(0.0,'rgba(0,0,0,.4)');
    grad.addColorStop(0.5,'rgba(0,0,0,0)');
    grad.addColorStop(1.0,'rgba(0,0,0,0.4)');
    
    ctx.beginPath();
    ctx.strokeStyle=grad;
    // ctx.strokeStyle="#333333";
    ctx.lineWidth=14;
    ctx.arc(cWidth/2,cHeight/2,100,(Math.PI/180)*0,(Math.PI/180)*360,false);
    ctx.stroke();
    ctx.closePath();
    
    //======== bevel arc
    
    grad=ctx.createLinearGradient(cWidth/2,0,cWidth/2,cHeight);
    grad.addColorStop(0.0,'#6c6f72');
    grad.addColorStop(0.5,'#252424');
    
    ctx.beginPath();
    ctx.strokeStyle=grad;
    ctx.lineWidth=1;
    ctx.arc(cWidth/2,cHeight/2,93,(Math.PI/180)*0,(Math.PI/180)*360,true);
    ctx.stroke();
    ctx.closePath();
    
    //====== emboss arc
    
    grad=ctx.createLinearGradient(cWidth/2,0,cWidth/2,cHeight);
    grad.addColorStop(0.0,'#ffffff');
    grad.addColorStop(0.98,'#6c6f72');
    
    ctx.beginPath();
    ctx.strokeStyle=grad;
    ctx.lineWidth=1;
    ctx.arc(cWidth/2,cHeight/2,107,(Math.PI/180)*0,(Math.PI/180)*360,true);
    ctx.stroke();
    ctx.closePath();
    
    //====== Labels
    
    var textColor='#646464';
    var textSize="35";
    var fontFace="helvetica, arial, sans-serif";
    
    // ctx.fillStyle=textColor;
    // ctx.font=textSize+"px "+fontFace;
    // ctx.fillText('MIN',cWidth/2-46,cHeight/2-40);
    // ctx.fillText('SC',cWidth/2+25,cHeight/2-15);
    // ctx.fillText('Hour',cWidth/2-15,cHeight/2-30);

    //====== Values
    
    
    
    ctxclock.fillStyle='#6292ae';
    ctxclock.fillStyle=textColor;
    ctxclock.font=textSize+"px "+fontFace;
    ctxclock.fillText('m',cWidth/2+45,cHeight/2);
    ctxclock.fillText('h',cWidth/2-35,cHeight/2);


    if(hour>0){
      ctxclock.font='35px '+fontFace;
      ctxclock.fillText(hour,cWidth/2-55, cHeight/2);

      ctxclock.font = '35px '+fontFace;
      ctxclock.fillText(min ,cWidth/2,cHeight/2);
    }
    else{
      ctxclock.font='35px '+fontFace;
      ctxclock.fillText('0',cWidth/2-55, cHeight/2);

      ctxclock.font = '35px '+fontFace;
      ctxclock.fillText(min ,cWidth/2,cHeight/2);
    }

    
    if (sec<=0 && counter<countTo) {
      angle+=inc;
      counter++;
      min--;
      sec=59; 
    } else
      if (counter>=countTo) {
        hour=0;
        min=0;
      } else {
        angle+=inc;
        counter++;
        sec--;
      }
    if (min<0 && counter<countTo) {
      hour--;
      min =59;
    }
  }
  setInterval(drawScreen,1000);
  
})()