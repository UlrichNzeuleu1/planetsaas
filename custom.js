jQuery(document).ready(function($) {
  // HTML del contenedor a añadir
  const starContent = `
    <div class="star_content">
      <div id="stars"></div>
      <div id="stars2"></div>
      <div id="stars3"></div>
    </div>
  `;

  // Añadir al principio de #star_container
  $('#star_container').prepend(starContent);
});
