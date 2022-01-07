import random
import numpy as np
import pandas as pd
from keras.models import Sequential
from keras.layers import Dense
from keras.layers import InputLayer
from tensorflow.keras.utils import to_categorical
from sklearn.model_selection import train_test_split
from sklearn.metrics import confusion_matrix

def train_reward_model():
    df = pd.DataFrame(columns = ['lit', 'hist', 'art', 'needs'])
    for i in range(20):

        #Randomly create a courseload with different numbers of questions.
        numbers = sorted(random.sample(range(100), 2))
        lit_questions = numbers[0]
        hist_questions = numbers[1] - numbers[0]
        art_questions = 100 - numbers[1]

        #Ask the user for their preferences
        print("Imagine a course with the following number of questions for each subject:")
        print(f"1 - Literature: {lit_questions}")
        print(f"2 - History: {hist_questions}")
        print(f"3 - Art: {art_questions}")
        query = eval(input("Which subject needs a higher portion of questions?: "))
        if (query > 0 and query < 4):
            needs = query - 1
        else:
            needs = random.randint(0, 2)

        #Load the response into the database
        df.loc[len(df.index)] = [lit_questions / 100, hist_questions / 100, art_questions / 100, needs]

    #Filter the labels out of the dataset
    x = df[['lit', 'hist', 'art']].to_numpy()
    y = df['needs'].to_numpy()
    y = to_categorical(y)
    x_train, x_test, y_train, y_test = train_test_split(x, y, test_size=0.3, random_state=12)

    #print(x_train)
    #print(y_train)

    #Train the model
    model = Sequential()
    model.add(InputLayer(input_shape=(3,)))
    model.add(Dense(8, activation='relu'))
    model.add(Dense(8, activation='relu'))
    model.add(Dense(3, activation='softmax'))
    model.compile(loss='categorical_crossentropy', optimizer='adam', metrics=['accuracy'])
    #model.summary()

    model.fit(x_train, y_train, epochs=20, batch_size=16)
    '''
    predictions = model.predict(x_test) 
    classes = np.argmax(predictions, axis=1)
    print(y_test.argmax(axis=1))
    print(classes)
    print(confusion_matrix(y_test.argmax(axis=1),classes))
    '''

    return model

class Question:
    def __init__(self, question_text):
        self.text = question_text
        self.data = question_text.split("|")
        self.query = self.data[0]
        self.correct = self.data[1]
        self.wrong = self.data[2:len(self.data)]
        self.choices = self.data[1:len(self.data)]
    
    def ask_question(self):
        #Create an association between letter choices and answers.
        letter = 'A'
        question_dict = {}
        answer_set = set(self.choices)
        print(self.query)
        while (len(answer_set) > 0):
            answer = answer_set.pop()
            question_dict[letter] = answer
            print(f"{letter}: {answer}")
            letter = chr(ord(letter) + 1)
        
        #Ask for the user's answer, then determine if they are correct
        user_choice = input("Select an answer choice: ").upper()
        if (user_choice in question_dict.keys() and question_dict[user_choice] == self.correct):
            print("That's Correct!")
            return True
        else:
            print("That's Incorrect.")
            return False

        
class Lesson:
    def __init__(self, lesson_text):
        self.text = lesson_text
        self.data = lesson_text.split("\n")
        self.url = self.data[0]
        self.questions = [Question(q) for q in self.data[1:len(self.data)]]
        self.total = len(self.questions)
    
    def show_lesson(self):
        #Ask the user to read the specified article at the designated URL
        print("Please read the following lesson: ")
        print(self.url)
        print()
        input("When you have finished the lesson, press the enter key to continue.")
        print()

        #Ask the relevant questions for that article
        correct = 0
        for q in range(len(self.questions)):
            print(f"Question {q+1}: ")
            correct += self.questions[q].ask_question()
            print()
        

        return [correct, self.total]


def main():
    #Open the lesson/question data from the files
    question_file = open('lit_lessons.txt', 'r')
    lit = question_file.read().split("\n\n")
    question_file = open('hist_lessons.txt', 'r')
    hist = question_file.read().split("\n\n")
    question_file = open('art_lessons.txt', 'r')
    art = question_file.read().split("\n\n")

    #Remove bad data
    if ('\n' in lit):
        lit.remove('\n')
    
    if ('\n' in hist):
        hist.remove('\n')
    
    if ('\n' in art):
        art.remove('\n')
    
    if ('' in lit):
        lit.remove('')
    
    if ('' in hist):
        hist.remove('')
    
    if ('' in art):
        art.remove('')
    
    #Convert text into lesson classes
    lit_lessons = [Lesson(lesson) for lesson in lit]
    hist_lessons = [Lesson(lesson) for lesson in hist]
    art_lessons = [Lesson(lesson) for lesson in art]

    correct_lit = 0
    correct_hist = 0
    correct_art = 0
    total = 0

    #Get the reward model
    model = train_reward_model()
    while (True):
        #Determine how well the user is doing so far
        if (total > 0):
            input_data = np.array([[correct_lit / total, correct_hist / total, correct_art / total]])
        else:
            input_data = np.array([[0, 0, 0]])
        
        #Use the reward model to find the next lesson.
        anti_rewards = model.predict(input_data)
        lesson_picked = np.argmax(anti_rewards, axis=1)

        #Give the next lesson and tally the results
        if (lesson_picked == 0):
            print("Current Lesson: Literature")
            current_lesson = lit_lessons[random.randint(0, len(lit_lessons) - 1)]
            results = current_lesson.show_lesson()
            correct_lit += results[0]
            total += results[0]
        elif (lesson_picked == 1):
            print("Current Lesson: History")
            current_lesson = hist_lessons[random.randint(0, len(hist_lessons) - 1)]
            results = current_lesson.show_lesson()
            correct_hist += results[0]
            total += results[0]
        else:
            print("Current Lesson: Art")
            current_lesson = art_lessons[random.randint(0, len(art_lessons) - 1)]
            results = current_lesson.show_lesson()
            correct_art += results[0]
            total += results[0]
        
        #Print a progress report
        print()
        print("Progress Report:")
        print(f"Correct Literature: {correct_lit}")
        print(f"Correct History: {correct_hist}")
        print(f"Correct Art: {correct_art}")
        print(f"Total: {total}")
        print()

        #Ask the user if they are finished and want to exit the program
        end = input("If you are finished, press Q and enter. Else, press enter: ").upper()
        if (end == "Q"):
            break

main()

