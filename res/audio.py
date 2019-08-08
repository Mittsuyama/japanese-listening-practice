import os
from pydub import AudioSegment
from pydub.silence import split_on_silence

class Listen:
    def __init__(self):
        self.list_dir = os.listdir()
    
    def fileDir(self, dir, str):
        if str == "txt":
            return dir + "/" + "pro.txt"
        if str == "time":
            return dir + "/" + dir + "time.txt"
        if str == "mp3":
            return dir + "/" + "pro.mp3"

    def dirJudge(self, dir):
        if not os.path.isdir(dir):
            return False
        if not os.path.exists(self.fileDir(dir, "mp3")):
            return False
        if os.path.exists(dir + "/ok"):
            return False
        return True
    
    def msCount(self, minute, second):
        return (int(minute) * 60 + int(second)) * 1000

    def strToMs(self, str):
        str_list = str.split("-")
        return self.msCount(str_list[1], str_list[2])

    def main(self):
        for dir in self.list_dir:
            if not self.dirJudge(dir):
                continue
            print("读取文件：" + dir)
            audio_file = AudioSegment.from_mp3(self.fileDir(dir, "mp3"))
            print("读取完毕，开始分割")
            # time_list = open(self.fileDir(dir, "time"), "r").readlines()

            chunks = split_on_silence(audio_file, min_silence_len = 100, silence_thresh = -70)
            chunks_len = len(chunks)
            chunks_order = 0
            res_order = 0
            print("分割完毕，开始保存文件")
            while chunks_order < chunks_len:
                now_audio = chunks[chunks_order]
                chunks_order += 1
                while chunks_order < chunks_len:
                    if len(now_audio) + len(chunks[chunks_order]) < 10 * 1000:
                        now_audio += chunks[chunks_order]
                        chunks_order += 1
                    else:
                        break
                print(str(res_order) + ": " + str(round(float(len(now_audio)) / 1000.0, 2)) + "s")
                now_audio.export(dir + "/" + str(res_order) + ".mp3", format = "mp3")
                res_order += 1
            print("\n")
            res = open(dir + "/ok", "w")
            res.close()

if __name__ == "__main__":
    Listen().main()