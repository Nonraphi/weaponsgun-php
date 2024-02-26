function loginFunction() {
  // ทำสิ่งที่คุณต้องการในกรณี Login
  // ซ่อนปุ่ม Login
  document.getElementById("loginButton").style.display = "none";
  // แสดงปุ่ม Logout
  document.getElementById("logoutButton").style.display = "block";
}

class Footer extends HTMLElement {
  constructor() {
    super();
  }

  connectedCallback() {
    this.innerHTML = ` 
    <footer>
      <div class="footer-info">
        <p>Copyright © 2023 all rights reserved</p>
        <p>by JayPondTik Co.,Ltd.</p>
      </div>
    </footer>
    `
  }
}

customElements.define('footer-component', Footer);

