var Game = function (i_name) {
	var name = i_name;

	this.register = function() {
		console.log("Register player: " + name);
		$.get("http://warships.ondrejkrejcir.cz/register.php", { name: name }, function (data, status) {
			console.log(data.key, status);
		})
	}
};

$(document).ready(function() {
	var game = new Game("Krejčíř");
	game.register();
});