if (screen.width <= 768) {
	let nav = document.querySelector(".elementor-nav-menu--dropdown > ul");
    let liMeuPerfil = document.createElement("li");
    liMeuPerfil.className =
      "menu-item menu-item-type-post_type menu-item-object-page";

    let aMeuPerfil = document.createElement("a");
    aMeuPerfil.textContent = "Minha Conta";
    aMeuPerfil.className = "elementor-item"
    aMeuPerfil.setAttribute("href", "https://cacaboom.com.br/minha-conta/");

    liMeuPerfil.appendChild(aMeuPerfil);
    nav.prepend(liMeuPerfil);
} 