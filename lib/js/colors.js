function pebbleColors() {
        var palette = [
        '#AAFF55',
        '#FFFFAA',
        '#AAAAAA',
        '#FFFFFF',
        '#AAFFAA',
        '#55FF00',
        '#AAFF00',
        '#FFFF55',
        '#000000',
        '#555555',
        '#55FF55',
        '#00FF00',
        '#FFFF00',
        '#FFAA55',
        '#00FF55',
        '#00AA00',
        '#55AA00',
        '#AAAA55',
        '#AAAA00',
        '#FFAA00',
        '#FF5500',
        '#FFAAAA',
        '#55FFAA',
        '#00AA55',
        '#55AA55',
        '#005500',
        '#555500',
        '#AA5500',
        '#FF0000',
        '#FF5555',
        '#00FFAA',
        '#00AAAA',
        '#55AAAA',
        '#005555',
        '#AA5555',
        '#FF0055',
        '#55FFFF',
        '#00FFFF',
        '#0055AA',
        '#550000',
        '#AA0000',
        '#AAFFFF',
        '#00AAFF',
        '#0000AA',
        '#000055',
        '#550055',
        '#AA0055',
        '#FF00AA',
        '#55AAFF',
        '#0000FF',
        '#5500FF',
        '#5500AA',
        '#AA00AA',
        '#FF00FF',
        '#FF55AA',
        '#0055FF',
        '#5555FF',
        '#5555AA',
        '#AA00FF',
        '#AA55AA',
        '#FF55FF',
        '#FFAAFF',
        '#AAAAFF',
        '#AA55FF'
      ];

    var newArray = [];

      for(var i = 0; i<palette.length; i++) {
        var newColor = hexToRgb(palette[i]);
        newArray.push([newColor.r, newColor.g, newColor.b]);
      }

    return newArray;
}

function hexToRgb(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
}