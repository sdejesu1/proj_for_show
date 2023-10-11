// jdh CS3240A / CS 5990A Fall 2023

import java.util.List;
import java.util.ArrayList;
import java.util.Stack;
import java.util.Map;
import java.util.HashMap;

public class Graph {
    List<Node> nodes;

    public Graph() {
        this.nodes = new ArrayList<Node>();
    }

    public void addNode(Node newNode) {
        for (Node n: this.nodes) {
            if (n == newNode) {
                System.out.println("ERROR: graph already has a node " + n.name);
                assert false;
            }
        }
        nodes.add(newNode);
    }

    public void addEdge(Node n1, Node n2) {
        // make sure edge does not already exist
        int idx1 = this.nodes.indexOf(n1);
        if (idx1 >= 0) {
            for (Node adjnode: this.nodes.get(idx1).adjlist) {
                if (adjnode == n2) {
                    System.out.println("ERROR: there is already an edge from " + n1.name + " to " + n2.name);
                    return;
                }
            }
            this.nodes.get(idx1).addEdge(n2);
        } else {
            System.out.println("ERROR: node " + n1.name + " not found in graph");
        }

        int idx2 = this.nodes.indexOf(n2);
        if (idx2 >= 0) {
            this.nodes.get(idx2).addEdge(n1);
        } else {
            System.out.println("ERROR: node " + n2.name + " not found in graph");
        }
    } // addEdge()

    //----------------------------------------------------------------

    public void print() {
        for (Node n1: this.nodes) {
            System.out.print(n1 + ":");
            for (Node n2: n1.adjlist) {
                System.out.print(" " + n2);
            }
            System.out.print("|");
        }
        System.out.println();
    } // print()

    //----------------------------------------------------------------

    public List<Node> DFS(Node s) {
        // implement this

        // smallestCycle list of nodes
        List<Node> smallestCycle = new ArrayList<Node>();
        Stack<Node> stack = new Stack<Node>();
        stack.push(s);
        // explored hashmap
        Map<Node, Boolean> explored = new HashMap<Node, Boolean>();
        for (Node u : nodes){
            smallestCycle.add(u);
            explored.put(u, false);
        }
        while (!stack.isEmpty()) {
            Node u = stack.pop();
            if (explored.get(u) ==  false) {
                explored.put(u, true);
                for (Node v : u.adjlist) {
                    if (explored.get(v) == false) {
                        if (v.parent != null && explored.get(v.parent)) {
                            List<Node> currentCycle = new ArrayList<Node>();
                            currentCycle.add(v);
                            currentCycle.add(u);
                            Node w = u.parent;
                            currentCycle.add(w);
                            while (true){
                                // if its not a triangle, keep going (essentially), otherwise break because the cycle length is 3. Maybe a bit manufactured
                                if (w.parent != null && w != v.parent){
                                    if (!w.parent.adjlist.contains(u)){
                                        currentCycle.add(w.parent);
                                        if(v.parent == w.parent.parent){
                                            currentCycle.add(w.parent.parent);
                                        }
                                        break;
                                    }
                                    w = w.parent;
                                    currentCycle.add(w);
                                }
                                else{
                                     break;
                                }
                            }

                            //Node z = v.parent;

                            //while (z.parent != null){
                                //if (w.parent != null){
                                    //w = w.parent;
                                    //currentCycle.add(w);
                                //}
                        //}


                            if (currentCycle.size() < smallestCycle.size()){
                                smallestCycle = currentCycle;
                            }

                        }
                        v.parent = u;
                        stack.push(v);
                    }
                }
            }
        }
        return smallestCycle;
    } // DFS()

} // class Graph

