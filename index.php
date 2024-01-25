<div id="welcome-screen">
  <img src="images/fidomStore.png" alt="fidomhub">
  <div class="loader"></div>
</div>

<style>
    
#welcome-screen {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: #ffffff;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

#welcome-screen img {
  width: 150px;
  height: auto;
  margin-bottom: 20px;
}

.loader {
  width: 40px;
  height: 40px;
  border: 4px solid #f3f3f3;
  border-top: 4px solid #3498db;
  border-radius: 50%;
  animation: spin 2s linear infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

h1 {
  font-size: 24px;
  color: #000000;
  margin-top: 20px;
}

</style>
<script>
    window.addEventListener('load',function(){
        var redirectDelay =5000;

        setTimeout(function(){
            window.location.href = "dashboard.php";
        },redirectDelay);
    });
</script>