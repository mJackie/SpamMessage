#!usr/bin/env python  
#-*- coding: utf-8 -*-  
# liu13 2017.12.15
# jackieliu.win

import jieba
import jieba.posseg as pseg
import sklearn.feature_extraction.text
import cPickle as pickle
from scipy import sparse, io
import sys



# generate word vector using tf-idf weight
class TfidfVectorizer(sklearn.feature_extraction.text.TfidfVectorizer):
    def build_analyzer(self):
        def analyzer(doc):
            words = pseg.cut(doc)
            new_doc = ''.join(w.word for w in words if w.flag != 'x')
            words = jieba.cut(new_doc)
            return words
        return analyzer

gpus = sys.argv[1]
text = [gpus];

test_classifiers = ['KNN', 'LR', 'RF', 'DT', 'GBDT', 'SVM', 'MultinomialNB','BernoulliNB']

for classifier in test_classifiers:
    vec_tfidf = pickle.load(open("/Users/liu/Sites/Model/all_raw/vec_tfidf", 'rb')) #note absolute path
    data_tfidf = vec_tfidf.transform(text)
    model = pickle.load(open('/Users/liu/Sites/Model/all_raw/model/'+classifier, 'rb'))

    predict = model.predict(data_tfidf)
    print(classifier +':')
    # 结果print为[u'0']，[u'1'] ，比较时仍直接数字
    if predict == "0":
        print("False(非垃圾短信)")
    elif predict == "1":
        print("True(垃圾短信)")
    print(",")









