<style>  
  .stats-banner {    
    margin: 0 auto;
    background: linear-gradient(90deg, #f2578c 0%, #f2894f 55%, #f7ab3c 100%);
    border-radius: 4px;
    padding: 40px 20px;
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    gap: 30px;
  }
  .stat-item {
    text-align: center;
    min-width: 150px;
  }
  .stat-number {
    font-size: 48px;
    font-weight: 800;
    color: #ffffff;
    line-height: 1;
    letter-spacing: 0.5px;
  }
  .stat-label {
    /* margin-top: 10px; */
    font-size: 13px;
    font-weight: 400;
    color: rgba(255, 255, 255, 0.95);
  }
  @media (max-width: 700px) {
    .stat-number { font-size: 34px; }
    .stat-label { font-size: 13px; }
  }
</style>

<div class="stats-banner">
  <div class="stat-item">
    <div class="stat-number" data-target="200">0+</div>
    <div class="stat-label">Sản phẩm đã bán</div>
  </div>
  <div class="stat-item">
    <div class="stat-number" data-target="600">0+</div>
    <div class="stat-label">Phụ huynh quan tâm</div>
  </div>
  <div class="stat-item">
    <div class="stat-number" data-target="400">0+</div>
    <div class="stat-label">Phụ huynh đã mua</div>
  </div>
  <div class="stat-item">
    <div class="stat-number" data-target="400">0+</div>
    <div class="stat-label">Phụ huynh hài lòng</div>
  </div>
</div>

<script>
  function animateCount(el, target, duration) {
    let startTime = null;
    function step(timestamp) {
      if (!startTime) startTime = timestamp;
      const progress = Math.min((timestamp - startTime) / duration, 1);
      const eased = 1 - Math.pow(1 - progress, 3);
      const current = Math.floor(eased * target);
      el.textContent = current + "+";
      if (progress < 1) {
        requestAnimationFrame(step);
      } else {
        el.textContent = target + "+";
      }
    }
    requestAnimationFrame(step);
  }

  window.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".stat-number").forEach((el) => {
      const target = parseInt(el.getAttribute("data-target"), 10);
      animateCount(el, target, 1500);
    });
  });
</script>