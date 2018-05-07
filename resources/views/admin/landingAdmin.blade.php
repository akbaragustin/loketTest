@extends('layouts.index')
@section('content')

<style>
.clock {
  height: 20vh;
  color: white;
  font-size: 22vh;
  font-family: sans-serif;
  line-height: 20.4vh;
  display: flex;
  position: relative;
  /*background: green;*/
  overflow: hidden;
}

.clock::before, .clock::after {
  content: '';
  width: 7ch;
  height: 3vh;
  background: linear-gradient(to top, transparent, black);
  position: absolute;
  z-index: 2;
}

.clock::after {
  bottom: 0;
  background: linear-gradient(to bottom, transparent, black);
}

.clock > div {
  display: flex;
}

.tick {
  line-height: 17vh;
}

.tick-hidden {
  opacity: 0;
}

.move {
  animation: move linear 1s infinite;
}

@keyframes move {
  from {
    transform: translateY(0vh);
  }
  to {
    transform: translateY(-20vh);
  }
}
</style>
    <!-- page content -->
    <div class="right_col" role="main">

          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="dashboard_graph">
                <div class="row x_title">
                  <div class="col-md-12">
                    <h3>Welcome Akbar Test - LOKET <small>Please read Readme.md for detail use this dashboard</small></h3>
                  </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12" style="background:#000">
                <div class="clock">
                        <div class="hours">
                            <div class="first">
                            <div class="number">0</div>
                            </div>
                            <div class="second">
                            <div class="number">0</div>
                            </div>
                        </div>
                        <div class="tick">:</div>
                        <div class="minutes">
                            <div class="first">
                            <div class="number">0</div>
                            </div>
                            <div class="second">
                            <div class="number">0</div>
                            </div>
                        </div>
                        <div class="tick">:</div>
                        <div class="seconds">
                            <div class="first">
                            <div class="number">0</div>
                            </div>
                            <div class="second infinite">
                            <div class="number">0</div>
                            </div>
                        </div>
                    </div>  
                </div>

                <div class="clearfix"></div>
              </div>
            </div>

          </div>
          <br />
        </div>
    <!-- /page content -->

<script>
var hoursContainer = document.querySelector('.hours')
var minutesContainer = document.querySelector('.minutes')
var secondsContainer = document.querySelector('.seconds')
var tickElements = Array.from(document.querySelectorAll('.tick'))

var last = new Date(0)
last.setUTCHours(-1)

var tickState = true

function updateTime () {
  var now = new Date
  
  var lastHours = last.getHours().toString()
  var nowHours = now.getHours().toString()
  if (lastHours !== nowHours) {
    updateContainer(hoursContainer, nowHours)
  }
  
  var lastMinutes = last.getMinutes().toString()
  var nowMinutes = now.getMinutes().toString()
  if (lastMinutes !== nowMinutes) {
    updateContainer(minutesContainer, nowMinutes)
  }
  
  var lastSeconds = last.getSeconds().toString()
  var nowSeconds = now.getSeconds().toString()
  if (lastSeconds !== nowSeconds) {
    //tick()
    updateContainer(secondsContainer, nowSeconds)
  }
  
  last = now
}

function tick () {
  tickElements.forEach(t => t.classList.toggle('tick-hidden'))
}

function updateContainer (container, newTime) {
  var time = newTime.split('')
  
  if (time.length === 1) {
    time.unshift('0')
  }
  
  
  var first = container.firstElementChild
  if (first.lastElementChild.textContent !== time[0]) {
    updateNumber(first, time[0])
  }
  
  var last = container.lastElementChild
  if (last.lastElementChild.textContent !== time[1]) {
    updateNumber(last, time[1])
  }
}

function updateNumber (element, number) {
  //element.lastElementChild.textContent = number
  var second = element.lastElementChild.cloneNode(true)
  second.textContent = number
  
  element.appendChild(second)
  element.classList.add('move')

  setTimeout(function () {
    element.classList.remove('move')
  }, 990)
  setTimeout(function () {
    element.removeChild(element.firstElementChild)
  }, 990)
}

setInterval(updateTime, 100)
</script>
@stop