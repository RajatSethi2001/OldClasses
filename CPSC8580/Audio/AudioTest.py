import librosa

y, sr = librosa.load('TestSpeech.wav', sr=16000)

sound = AudioSegment.from_file('TestSpeech.wav', format='wav')

octaves = 0.5
new_rate = int(sound.frame_rate * (2.0 ** octaves))

hipitch_sound = sound._spawn(sound.raw_data, overrides={'frame_rate': new_rate}).set_frame_rate(44100)

play(hipitch_sound)

