var Game = function (i_name) {
	var size = 10;
	var name = i_name;
	var key = null;
	var flag = true;
	var won = false;

	this.register = function () {
		key = $("#player_id").data("hash");
		console.log(hash);
	};

	var createArray = function () {
		var array = new Array(size);
		for (var i = 0; i < size; i++) {
			array[i] = new Array(size);
		}
		return array;
	};
	var playground = createArray();

	var shoot = function () {
		if (!flag) {
			return;
		}
		var x = Math.floor(Math.random() * 10);
		var y = Math.floor(Math.random() * 10);
		console.log("Shooting at [" + x + "," + y + "]");

		flag = false;
		$.get("http://warships.ondrejkrejcir.cz/shoot.php", {hash: key, x: x, y: y}, function (data, status) {
			playground[data.x][data.y] = data.hit;
		}).always(function () {
			flag = true;
		});
	};

	var check = function () {
		var hits = 0;
		for (var x = 0; x < playground.length; x++) {
			for (var y = 0; y < playground.length; y++) {
				if (playground[x][y]) {
					hits++;
				}
			}
		}
		if (hits < 4) return;
		$.get("http://warships.ondrejkrejcir.cz/check.php", {hash: key}, function (data, status) {
			if (status === "success") {
				won = true;
			}
		});
	};

	var drawPlayground = function () {
		var canvas = document.getElementById("canvas");
		var context = canvas.getContext("2d");
		if (won) {
			canvas.style.backgroundColor = "green";
		}
		context.clearRect(0, 0, canvas.width, canvas.height);
		for (var i = 1; i < size; i++) {
			context.beginPath();
			context.moveTo(0, 50 * i);
			context.lineTo(500, 50 * i);
			context.stroke();
			context.closePath();

			context.beginPath();
			context.moveTo(50 * i, 0);
			context.lineTo(50 * i, 500);
			context.stroke();
			context.closePath();
		}
		for (var i = 0; i < playground.length; i++) {
			for (var j = 0; j < playground[i].length; j++) {
				if (playground[i][j] === true) {
					context.beginPath();
					context.arc(50 * i + 25, 50 * j + 25, 20, 0, 2 * Math.PI);
					context.stroke();
					context.fill();
					context.closePath();
				}
				if (playground[i][j] === false) {
					context.beginPath();
					context.arc(50 * i + 25, 50 * j + 25, 20, 0, 2 * Math.PI);
					context.stroke();
					context.closePath();
				}
			}
		}
	};

	this.turn = function () {
		check();
		shoot();
		drawPlayground();
	}
};

$(document).ready(function () {
	var game = new Game("{PLAYER_NAME}");
	game.register();
	setInterval(game.turn, 2000);
});