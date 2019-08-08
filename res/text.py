import os
import MeCab

class Text:
    def __init__(self):
        self.list_dir = os.listdir()
        self.mecab = MeCab.Tagger("-Ochasen")
    
    def fileDir(self, dir, str):
        if str == "res":
            return dir + "/res.txt"
        if str == "txt":
            return dir + "/pro.txt"
        if str == "mp3":
            return dir + "/" + dir + ".mp3"

    def dirJudge(self, dir):
        if not os.path.isdir(dir):
            return False
        if not os.path.exists(self.fileDir(dir, "txt")):
            return False
        return True

    def participle(self, str):
        temp = ""
        node = self.mecab.parseToNode(str)
        while node:
            temp += "{(" + node.surface + ")["
            temp += node.feature + "]}"
            node = node.next
        temp += "\n"
        return temp

    def main(self):
        for dir in self.list_dir:
            if not self.dirJudge(dir):
                continue
            text_list = open(self.fileDir(dir, "txt"), "r").readlines()
            res = open(self.fileDir(dir, "res"), "w")
            for text in text_list:
                text = self.participle(text)
                res.write(text)
            res.close()

if __name__ == "__main__":
    Text().main()