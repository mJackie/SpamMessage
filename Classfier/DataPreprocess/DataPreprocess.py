# -*- coding: utf-8 -*-
# liu13 2017.12.14	
# jackieliu.win

from numpy import *
import json
import numpy as np
import jieba
import jieba.posseg as pseg
import sklearn.feature_extraction.text
from sklearn.decomposition import NMF
from sklearn.decomposition import PCA
from scipy import sparse, io
from time import time
import cPickle as pickle


# generate word vector using tf-idf weight
class TfidfVectorizer(sklearn.feature_extraction.text.TfidfVectorizer):
    def build_analyzer(self):
        def analyzer(doc):
            words = pseg.cut(doc)
            new_doc = ''.join(w.word for w in words if w.flag != 'x')
            words = jieba.cut(new_doc)
            return words
        return analyzer

# PCA or NMF dimensionality reduction
def dimensionality_reduction(x, type='pca'):
    if type == 'pca':
        n_components = 500   #reduct to n_components dimension，mle indicates auto select n_coponents
        t0 = time()
        pca = PCA(n_components=n_components)
        print "pca-----fit begin"
        pca.fit(x)
        print "pca-----fit ok"
        x_transform = sparse.csr_matrix(pca.transform(x))
        print "pca-----x ok"

        print("PCA reduction done in %0.3fs" % (time() - t0))
        
        return x_transform

    if type == 'nmf':
        n_components = 500   #reduct to n_components dimension
        t1 = time()
        nmf = NMF(n_components=n_components)
        print "nmf-----fit begin"
        nmf.fit(x)
        print "nmf-----fit ok"
        x_transform = sparse.csr_matrix(nmf.transform(x))
        print "nmf-----x ok"

        print("NMF reduction done in %0.3fs" % (time() - t1))
     
        return x_transform


if '__main__' == __name__:
    print '******************* data preprocessing ********************'
    t0 = time()
    data_lines = 50000;		# data lines, can be modified
    data_type = "raw"       # proccessed data type {raw, pca, nmf, pca&nmf}
    x = []
    y = [] 
    lines =[]

    # open the raw data, load to the array
    with open('message.txt') as fr:    #same as try ... finally，but more simpler
        for i in range(data_lines):  
            line = fr.readline()
            message = line.split('\t')
            y.append(message[0])
            x.append(message[1])

    # save y into y.json
    with open('raw50000/y.json', 'w') as f:
        json.dump(y, f)
    print "save y successfully!"

    vec_tfidf = TfidfVectorizer()   # if df<2 discard it, max_df>0.8 discard as well
    data_tfidf = vec_tfidf.fit_transform(x)
    # write to the file, recall for demoAPI
    #pickle.dump(vec_tfidf, open("vec_tfidf", 'wb'))

    if data_type == 'raw':
        io.mmwrite('raw50000/raw', data_tfidf)


    '''
    name_tfidf_feature = vec_tfidf.get_feature_names()	# write feature name into feature.json
    with open('feature.json', 'w') as f:
        json.dump(name_tfidf_feature, f)
    print "save feature successfully!"
    '''

    if data_type == 'nmf' or data_type == 'pca&nmf':
        nmf = dimensionality_reduction(data_tfidf.todense(), type='nmf')
        io.mmwrite('nmf', nmf)	# write nmf into nmf.mtx
        print "save nmf successfully!"

    if data_type == 'pca' or data_type == 'pca&nmf':
        pca = dimensionality_reduction(data_tfidf.todense(), type='pca')
        io.mmwrite('pca', pca)	# write pca into pca.mtx
        print "save pca successfully!"



    print("******* %s lines data preprocessing done in %0.3fs *******" % (data_lines,(time() - t0)))
