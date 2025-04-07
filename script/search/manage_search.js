export function manageSearch() {
    let wrap = $(".title_for_section");

    wrap.on("click", "#search_enabled", function () {
        wrap.find(".title_for_section__left").css("display", "none");
        wrap.find(".search_wrap").css("display", "none");
        $(".search_input_wrap").css("display", "flex");
    });

    wrap.on("click", "#search_back", function () {
      
        $(".search_input_wrap").css("display", "none");
        wrap.find(".title_for_section__left").css("display", "block");
        wrap.find(".search_wrap").css("display", "flex");

    });
}