# requests及びbs4を必ずインポートする
import requests
from bs4 import BeautifulSoup

# HTMLの取得先として当サイトを指定する
response = requests.get("https://pig-data.jp")

# BeautifulSoup4でサイトのテキストを取得し、
# 第二因数にhtml.parserを指定、解析結果をsoupに入れる
soup = BeautifulSoup(response.text,'html.parser')

# soup.find_all('a', text=True))でaタグに指定されている要素を抽出、
# print(element.getText())でテキストのみを出力する
for element in soup.find_all('a', text=True):
	print(element.getText())
