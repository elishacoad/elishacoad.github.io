{"changed":true,"filter":false,"title":"buttonFunc.js","tooltip":"/buttonFunc.js","value":"/*............ Functions Triggered by Button Presses ............*/\n\n// download the points so that python can create the gCode\nfunction pointsToString(path){\n\tvar segments = path.segments\n\tvar text = \"\";\n\tfor (var i=0; i < segments.length; i++){\n\t\tvar p = segments[i].point;\n\t\ttext += p.x + \",\" + p.y + \"\\n\";\n\t}\n\treturn text;\n}\n\nfunction download(filename, path) {\n\tvar text = pointsToString(path);\n\t// make a new anchor tag, add it to DOM, auto-click it and remove\n\tvar element = document.createElement('a');\n\telement.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));\n\telement.setAttribute('download', filename);\n\telement.style.display = 'none';\n\tdocument.body.appendChild(element);\n\telement.click();\n\tdocument.body.removeChild(element);\n}\n","undoManager":{"mark":-2,"position":5,"stack":[[{"start":{"row":0,"column":0},"end":{"row":24,"column":0},"action":"insert","lines":["/*............ Functions Triggered by Button Presses ............*/","","// download the points so that python can create the gCode","function pointsToString(path){","\tvar segments = path.segments","\tvar text = \"\";","\tfor (var i=0; i < segments.length; i++){","\t\tp = segments[i].point","\t\ttext += p.x + \",\" + p.y + \"\\n\";","\t}","\treturn text;","}","","function download(filename, path) {","\tvar text = pointsToString(path);","\t// make a new anchor tag, add it to DOM, auto-click it and remove","\tvar element = document.createElement('a');","\telement.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));","\telement.setAttribute('download', filename);","\telement.style.display = 'none';","\tdocument.body.appendChild(element);","\telement.click();","\tdocument.body.removeChild(element);","}",""],"id":1}],[{"start":{"row":7,"column":2},"end":{"row":7,"column":3},"action":"insert","lines":["v"],"id":2}],[{"start":{"row":7,"column":3},"end":{"row":7,"column":4},"action":"insert","lines":["a"],"id":3}],[{"start":{"row":7,"column":4},"end":{"row":7,"column":5},"action":"insert","lines":["r"],"id":4}],[{"start":{"row":7,"column":5},"end":{"row":7,"column":6},"action":"insert","lines":[" "],"id":5}],[{"start":{"row":7,"column":27},"end":{"row":7,"column":28},"action":"insert","lines":[";"],"id":6}]]},"ace":{"folds":[],"scrolltop":0,"scrollleft":0,"selection":{"start":{"row":7,"column":28},"end":{"row":7,"column":28},"isBackwards":false},"options":{"guessTabSize":true,"useWrapMode":false,"wrapToView":true},"firstLineState":{"row":91,"mode":"ace/mode/javascript"}},"timestamp":1482877689209}