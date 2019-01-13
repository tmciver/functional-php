.PHONY: docs

%.png : %.dot
	dot -Tpng $< -o $@

docs: typeclasses.png typeclasses-impl.png
