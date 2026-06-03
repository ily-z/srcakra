@php
$colors = $colors ?? [
'first' => '122,82,66',
'second' => '155,107,87',
'third' => '192,140,116',
'fourth' => '216,191,164',
'fifth' => '239,227,210',
'sixth' => '231,214,192',
];
@endphp

<div
class="bubble-bg fixed inset-0 overflow-hidden pointer-events-none"
aria-hidden="true"
style="--c1: {{ $colors['first'] }}; --c2: {{ $colors['second'] }}; --c3: {{ $colors['third'] }}; --c4: {{ $colors['fourth'] }}; --c5: {{ $colors['fifth'] }}; --c6: {{ $colors['sixth'] }};"
>
<svg xmlns="http://www.w3.org/2000/svg" class="absolute w-0 h-0">
<defs>
<filter id="bubble-goo">
<feGaussianBlur in="SourceGraphic" stdDeviation="16" result="blur" />
<feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -8" result="goo" />
<feBlend in="SourceGraphic" in2="goo" />
</filter>
</defs>
</svg>

<div class="absolute inset-0" style="filter: url(#bubble-goo) blur(40px)">
<div class="bubble-blob bubble-blob--1"></div>
<div class="bubble-blob bubble-blob--2">
<div class="bubble-blob__inner bubble-blob__inner--1"></div>
</div>
<div class="bubble-blob bubble-blob--3">
<div class="bubble-blob__inner bubble-blob__inner--2"></div>
</div>
<div class="bubble-blob bubble-blob--4"></div>
<div class="bubble-blob bubble-blob--5">
<div class="bubble-blob__inner bubble-blob__inner--3"></div>
</div>
<div class="bubble-blob bubble-blob--6" id="interactiveBubble"></div>
</div>
</div>

<style>
.bubble-bg {
z-index: -1;
}

.bubble-blob {
position: absolute;
inset: 0;
display: flex;
align-items: center;
justify-content: center;
will-change: transform;
}

.bubble-blob--1 {
animation: bubble-float 30s ease-in-out infinite;
}

.bubble-blob--2 {
transform-origin: calc(50% - 400px) center;
animation: bubble-spin 20s linear infinite;
}

.bubble-blob--3 {
transform-origin: calc(50% + 400px) center;
animation: bubble-spin-reverse 40s linear infinite;
}

.bubble-blob--4 {
animation: bubble-slide 40s ease-in-out infinite;
}

.bubble-blob--5 {
transform-origin: calc(50% - 800px) calc(50% + 200px);
animation: bubble-spin 20s linear infinite;
}

.bubble-blob__inner {
border-radius: 9999px;
width: 80%;
height: 80%;
mix-blend-mode: hard-light;
}

.bubble-blob__inner--1 {
background: radial-gradient(circle at center, rgba(var(--c2), 0.8) 0%, rgba(var(--c2), 0) 50%);
}

.bubble-blob__inner--2 {
position: absolute;
width: 80%;
height: 80%;
top: calc(50% + 200px);
left: calc(50% - 500px);
background: radial-gradient(circle at center, rgba(var(--c3), 0.8) 0%, rgba(var(--c3), 0) 50%);
mix-blend-mode: hard-light;
border-radius: 9999px;
}

.bubble-blob__inner--3 {
position: absolute;
width: 160%;
height: 160%;
top: calc(50% - 80%);
left: calc(50% - 80%);
background: radial-gradient(circle at center, rgba(var(--c5), 0.8) 0%, rgba(var(--c5), 0) 50%);
mix-blend-mode: hard-light;
border-radius: 9999px;
}

.bubble-blob--1 {
background: radial-gradient(circle at center, rgba(var(--c1), 0.8) 0%, rgba(var(--c1), 0) 50%);
border-radius: 9999px;
width: 80%;
height: 80%;
top: 10%;
left: 10%;
mix-blend-mode: hard-light;
}

.bubble-blob--4 {
background: radial-gradient(circle at center, rgba(var(--c4), 0.8) 0%, rgba(var(--c4), 0) 50%);
border-radius: 9999px;
width: 80%;
height: 80%;
top: 10%;
left: 10%;
mix-blend-mode: hard-light;
opacity: 0.7;
}

.bubble-blob--6 {
opacity: 0.7;
transition: opacity 0.3s;
pointer-events: none;
background: radial-gradient(circle at center, rgba(var(--c6), 0.8) 0%, rgba(var(--c6), 0) 50%);
border-radius: 9999px;
width: 120%;
height: 120%;
top: -10%;
left: -10%;
mix-blend-mode: hard-light;
}

@keyframes bubble-float {
0%, 100% { transform: translateY(-50px); }
50% { transform: translateY(50px); }
}

@keyframes bubble-spin {
from { transform: rotate(0deg); }
to { transform: rotate(360deg); }
}

@keyframes bubble-spin-reverse {
from { transform: rotate(0deg); }
to { transform: rotate(-360deg); }
}

@keyframes bubble-slide {
0%, 100% { transform: translateX(-50px); }
50% { transform: translateX(50px); }
}
</style>

<script>
(function() {
var bubble = document.getElementById('interactiveBubble');
if (!bubble) return;

var bg = bubble.closest('.bubble-bg');
var targetX = 0, targetY = 0;
var currentX = 0, currentY = 0;
var raf = null;

function updateRect() {
var rect = bg.getBoundingClientRect();
bg._cx = rect.left + rect.width / 2;
bg._cy = rect.top + rect.height / 2;
}

updateRect();
window.addEventListener('resize', updateRect);

bg.addEventListener('mousemove', function(e) {
targetX = e.clientX - bg._cx;
targetY = e.clientY - bg._cy;
if (!raf) raf = requestAnimationFrame(animate);
});

function animate() {
currentX += (targetX - currentX) * 0.08;
currentY += (targetY - currentY) * 0.08;

if (Math.abs(currentX - targetX) < 0.5 && Math.abs(currentY - targetY) < 0.5) {
currentX = targetX;
currentY = targetY;
raf = null;
} else {
raf = requestAnimationFrame(animate);
}

bubble.style.transform = 'translate3d(' + currentX + 'px,' + currentY + 'px,0)';
}
})();
</script>
